<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\JobCard\FreeServiceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    public function qrCodeData(Request $request){

        try{
            $auth = Auth::user();
            $chassisNo = $auth->ChassisNo;
            $checkFreeService = FreeServiceSchedule::where('FreeSScheduleID',$request->freeSScheduleID)->first();
            if($checkFreeService->Status == 1){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Already taken for service',
                ],403);
            }
            else{
                FreeServiceSchedule::where('FreeSScheduleID',$request->freeSScheduleID)->update([
                        'CustomerCode' => $request->qrServiceCenterCode,
                    ]);

                $customer = Customer::select('CustomerCode','CustomerName')->where('CustomerCode', $request->qrServiceCenterCode)->first();

                return response()->json([
                    'status' => 'success',
                    'customer' => $customer,
                ],200);
            }




        }
        catch
        (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . '-' . $exception->getLine()
            ], 500);
        }

    }
}
