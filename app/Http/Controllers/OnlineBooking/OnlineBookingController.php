<?php

namespace App\Http\Controllers\OnlineBooking;

use App\Http\Controllers\Controller;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineBookingController extends Controller
{
    use CommonTrait;

    public function getSupportingData()
    {
        $locations = DB::connection('MotorMC')
            ->select(DB::raw("SELECT DISTINCT C.CustomerCode, C.CustomerName, D.DistrictCode, D.DistrictName
                    FROM OnlineReservation R
                        INNER JOIN Customer C
                            ON R.CustomerCode = C.CustomerCode
                        INNER JOIN District D
                            ON C.DistrictCode = D.DistrictCode
                        WHERE  R.Active = 'Y'
                    ORDER BY D.DistrictName"));

        return response()->json([
            'status' => 'success',
            'locations' => $locations,
        ]);
    }

    public function getBayinfoByLocation(Request $request)
    {

        $bayList = DB::connection('MotorMC')->select(DB::raw("SELECT T1.*, T2.*  FROM [MotorMC].[dbo].[OnlineReservation]   T1
                        Inner Join [MotorMC].[dbo].[OnlineReservationDetails] T2 ON T1.CustomerCode = T2.CustomerCode
                        WHERE T1.CustomerCode = '$request->preferred_location' "));

        $timeSlots = DB::connection('MotorMC')->select(DB::raw("SELECT TimeSlotId, TimeSlot
                        FROM [192.168.100.201].dbYamahaServiceCenter.dbo.tblTimeSlot
                        WHERE Active='Y'
                        Order By TimeSlotId ASC"));

        $alreadyBooked = DB::connection('MotorMC')->select(DB::raw("SELECT * FROM (
                SELECT
                    ROW_NUMBER() OVER (PARTITION BY TimeSlotId, BayName ORDER BY TimeSlotId, BayName) SL,
                    TimeSlotId, BayName, CustomerName, count(TimeSlotId) AS BookCount
                    FROM [192.168.100.201].dbYamahaServiceCenter.dbo.tblOnlineBooking
                    WHERE ServiceCenterCode = '$request->preferred_location' AND Convert(varchar(10),ServiceDate, 120) = '$request->preferreddate'
                    Group By BayName,TimeSlotId,CustomerName
                ) S
                WHERE SL = 1
                Order By TimeSlotId ASC"));

        $serviceType = DB::connection('MotorMC')->select(DB::raw("SELECT ServiceType,ServiceTypeName  FROM [MotorMC].[dbo].[YSparkServiceType] where Active='Y'"));


        return response()->json([
            'status' => 'success',
            'bayList' => $bayList,
            'timeSlots' => $timeSlots,
            'serviceType' => $serviceType,
            'alreadyBooked' => $alreadyBooked,
        ]);
    }

    public function onlineBooking(Request $request)
    {
        // ==================Below code for Cannot book in same location in 15 days of last booking=============================

        $chassisNo = $request->chassisNo;
        $mobileNo = $request->mobileNo;
        $customerName = $request->customerName;
        $brandName = $request->brandName;
        $kilometerDone = $request->kilometerDone;
        $problemDetails = $request->problemDetails;
        $preferredDate = $request->preferredDate;
        $preferredLocation = $request->preferredLocation;
        $bayName = $request->bayName;
        $timeSlotId = $request->timeSlotId;
        $serviceType = $request->serviceType;
        $serviceTypeName = $request->serviceTypeName;
        $entryIp = $request->ip();


        try {
            $lastBooking = DB::connection('MotorMC')->select(DB::raw("SELECT TOP 1 * FROM [192.168.100.201].dbYamahaServiceCenter.dbo.tblOnlineBooking
                     WHERE ServiceCenterCode='$preferredLocation'
                         AND ChassisNo='$chassisNo'
                         ORDER BY ServiceDate DESC"));

            if (!empty($lastBooking)) {
                $lastBookingDate = date_create($lastBooking[0]->ServiceDate);
                $lastBookingDate = date_add($lastBookingDate, date_interval_create_from_date_string("14 days"));
                $lastBookingDate = date_format($lastBookingDate, "Y-m-d");

                if ($request->PreferredDate <= $lastBookingDate) {
                    return response()->json([
                        'status' => 'error',
                        'locations' => 'Reservation already  made for chassis-' . $chassisNo . ' at ' . date("Y-m-d", strtotime($lastBooking[0]->ServiceDate)) . '. You can book again to this Service center after 15 days'
                    ]);
                }
            }


            $holiday = DB::connection('MotorMC')->select(DB::raw("SELECT
                    COUNT(*) doCount
                    FROM HoliDays WHERE Remarks != 'WeekEnd'
                    AND HolidayDate = '$preferredDate'"));

            if ($holiday[0]->doCount > 0) {
                return response()->json([
                    'status' => 'error',
                    'locations' => 'Reservation not available in Holiday. Please try another day.'
                ]);
            }

            $friday = date('D', strtotime($preferredDate));
            if ($friday == 'Fri') {
                return response()->json([
                    'status' => 'error',
                    'locations' => 'Reservation not available in Friday. Please try other.'
                ]);

            }

            $noOfBay = DB::connection('MotorMC')->select(DB::raw("SELECT *  FROM [MotorMC].[dbo].[OnlineReservation]   WHERE CustomerCode = '$preferredLocation'"));
            $totalReserved = DB::connection('MotorMC')->select(DB::raw("SELECT count(*) AS Reserved FROM [192.168.100.201].dbYamahaServiceCenter.dbo.tblOnlineBooking
                            WHERE ServiceDate='$preferredDate'
                            AND TimeSlotId='$timeSlotId'
                            AND ServiceCenterCode = '$preferredLocation'"));

            $totalReserved = $totalReserved[0]->Reserved + 1;
            if ($totalReserved > $noOfBay) {
                return response()->json([
                    'status' => 'error',
                    'locations' => 'Reservation not available for selected slot. Please try another slot.'
                ]);
            };

            if ($onlineBooking = DB::connection('MotorMC')
                ->select(
                    DB::raw("exec [192.168.100.201].dbYamahaServiceCenter.dbo.usp_doInsertOnlineBookingUpdate
                '$preferredDate','$timeSlotId','$bayName','$serviceType',
                '$serviceTypeName','$customerName','$mobileNo','$chassisNo',
                '$brandName','$entryIp','$kilometerDone','$preferredLocation',
                '$problemDetails'"))) {


            }
            $OnlineBookingId = $onlineBooking[0]->InsertID;

            $reservationNo = $OnlineBookingId;

            $dealerInfo = DB::connection('MotorMC')->select(DB::raw("SELECT CustomerEmail, MobileNO
                                FROM [192.168.100.25].MotorMC.Dbo.OnlineReservation
                                WHERE CustomerCode = '$preferredLocation'"));

            $dealerName = DB::connection('MotorMC')->select(DB::raw("SELECT CustomerName
                            FROM [192.168.100.25].MotorMC.Dbo.Customer
                            WHERE CustomerCode = '$preferredLocation'"));


            $Timeslot = DB::connection('MotorMC')->select(DB::raw("SELECT TImeSlot from [192.168.100.201].dbYamahaServiceCenter.dbo.tblTimeSlot WHERE TimeSlotId='$timeSlotId'"));


            $dealarsms = "Dear Concern,\n One Online Reservation has been confirmed with the following information\n Customer Name : {$customerName}\nMobile No : {$mobileNo}\nChassis No : {$chassisNo}\nService Date : {$request->PreferredDate}\nTime Slot : " . date('h:i A', strtotime($Timeslot[0]->TImeSlot)) . "\nService Type : {$serviceTypeName}\nReservation No : {$reservationNo}\nPlease arrive before 10 Min. Otherwise your reservation will be cancelled.";
            $customersms = "Dear Valuable Customer,\nThank you for your online service reservation.\nReservation No: {$reservationNo}\nDealer Point: {$dealerName[0]->CustomerName}\nReservation Date: {$preferredDate}\nBooking Time: " . date('h:i A', strtotime($Timeslot[0]->TImeSlot)) . "\nService Type: {$serviceTypeName}\nPlease don't miss the booking time and arrive 10 minutes earlier. otherwise, bookings will be cancelled. ";

            $customerMobileNo = $mobileNo;
            $dealarmobileno = $dealerInfo[0]->MobileNO;

            if (!empty($dealarmobileno)) {
                $this->sendSmsQ($dealarmobileno, '8809617615000', 'YamahaBooking', 'Y_Spark', '', $preferredLocation, 'smsq', $dealarsms);
            }

            if (!empty($customerMobileNo)) {
                $this->sendSmsQ($customerMobileNo, '8809617615000', 'YamahaBooking', 'Y_Spark', '', $preferredLocation, 'smsq', $customersms);

            }

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully reserved your online booking.  Your online booking id : ' . $reservationNo,
            ], 200);
        } catch
        (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . '-' . $exception->getLine()
            ], 500);
        }

//
//            Session::flash('success', 'Successfully reserved your online booking.  Your online booking id : ' . $reservationNo);
//
//        }

    }
}
