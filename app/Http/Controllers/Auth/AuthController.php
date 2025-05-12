<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DealarInvoiceDetails;
use App\Models\User;
use App\Models\ViewRetailCustomer;
use App\Models\YSparkLogin;
use App\Models\YSparkSmsLog;
use App\Traits\CommonTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\jwt\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{
    use CommonTrait;
    public function login(Request $request)
    {
        $chassisNo = $request->chassisNo;
//        $user = DealarInvoiceDetails::select('DealarInvoiceDetails.ChassisNo', 'DealarInvoiceMaster.MobileNo', 'DealarInvoiceMaster.CustomerCode')
//            ->join('DealarInvoiceMaster', 'DealarInvoiceMaster.InvoiceID', 'DealarInvoiceDetails.InvoiceID')
//            ->Where('Chassisno', $chassisNo)
//            ->first();
        $user = DB::select("
                            SELECT TOP 1
                                DealarInvoiceDetails.ChassisNo,
                                DealarInvoiceMaster.MobileNo,
                                DealarInvoiceMaster.CustomerCode
                            FROM
                                DealarInvoiceDetails WITH(NOLOCK)
                            INNER JOIN
                                DealarInvoiceMaster WITH(NOLOCK)
                            ON
                                DealarInvoiceMaster.InvoiceID = DealarInvoiceDetails.InvoiceID
                            WHERE
                                DealarInvoiceDetails.ChassisNo = ?
                        ", [$chassisNo]);

        if ( !empty($user) && $user[0]) {
            $customerCode = $user[0]->CustomerCode;
            $mobileNo = $user[0]->MobileNo;

            $SixDigitRandomNumber = rand(100000, 999999);
            $ySparkLoginUser = new YSparkLogin();
            $ySparkLoginUser->ChassisNo = $chassisNo;
            $ySparkLoginUser->MobileNo = $mobileNo;
            $ySparkLoginUser->LoginCode = $SixDigitRandomNumber;
            $ySparkLoginUser->OtpVerification = 0;
            $ySparkLoginUser->OtpExpiration = Carbon::now()->addMinutes(5);;
            $ySparkLoginUser->save();

            $smscontent = 'ওয়াই স্পার্ক লগিনের জন্য আপনার ওটিপি কোডটি হলো- ' . $SixDigitRandomNumber;
            $respons = $this->sendSmsQ($mobileNo, 'YSPARKOTP', 'Y_Spark', 'Y_Spark', '', $customerCode, 'sslcom', $smscontent);;
            $responseStatus = json_decode($respons)->message;

            //Data Insert Sms Log
            $smsLog = new YSparkSmsLog();
            $smsLog->MobileNumber = $mobileNo;
            $smsLog->Message = $smscontent;
            $smsLog->ApiSmsResponse = $responseStatus;
            $smsLog->SentTime = Carbon::now()->format('Y-m-d H:i:s');
            $smsLog->CreatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $smsLog->UpdatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $smsLog->save();

            if ($responseStatus == 'success') {
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Code Sent Successfully!'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Failed to sent code!'
                ], 401);

            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid Chassis Number!'
            ], 401);
        }
    }

    //Otp Verification
    public function otpVerification(Request $request)
    {
        $otpCode = $request->otpCode;
        $chassisNo = $request->chassisNo;
        $user = YSparkLogin::select(
            'ViewRetailCustomer.CustomerName',
            'ViewRetailCustomer.ChassisNo',
            'ViewRetailCustomer.MobileNo',
            'ViewRetailCustomer.PreAddress',
            'ViewRetailCustomer.ProductName as BikeModel',
            'YSparkLogin.LoginCode',
            'YSparkLogin.OtpVerification',
            'YSparkLogin.OtpExpiration')
            ->join('ViewRetailCustomer',function ($q) use($chassisNo) {
                $q->on('ViewRetailCustomer.ChassisNo','YSparkLogin.ChassisNo');
                $q->where('ViewRetailCustomer.ChassisNo',$chassisNo);
            })
            ->where('YSparkLogin.ChassisNo', $chassisNo)
            ->where('ViewRetailCustomer.ChassisNo', $chassisNo)
            ->where('YSparkLogin.LoginCode', $otpCode)
            ->where('YSparkLogin.LoginCode', $otpCode)
            ->first();
        try {
            if ($user) {
                $mobileNo = $user->MobileNo;
                    $token=$this->generateToken($user);
                // OTP is valid, issue JWT token
                if ($mobileNo && $token) {
                    $user->OtpVerification = 1;
                    $user->save();
                    return $this->respondWithToken($token,$user);
                }
                return response()->json([
                    'status' => 'Success',
                    'message' => 'Code Sent Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Otp Code!'
                ], 401);
            }

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'Something Went Wrong',
                'message' => $exception->getMessage().' '.$exception->getLine()
            ], 500);
        }
    }

    protected function respondWithToken($token, $userDetails)
    {
//        dd($user);
        return response()->json([
            'access_token' => $token,
            'Data' => $userDetails,
        ]);
    }

    public function logout()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            $this->guard()->logout();
        } catch (\Exception $exception) {

        }
        return response()->json(['message' => 'Successfully logged out']);
    }

    function sendSmsQ($to, $sId, $applicationName, $moduleName, $otherInfo, $userId, $vendor, $message)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.102.10/apps/api/send-sms/sms-master',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'To=' . $to . '&SID=' . $sId . '&ApplicationName=' . urlencode($applicationName) . '&ModuleName=' . urlencode($moduleName) . '&OtherInfo=' . urlencode($otherInfo) . '&userID=' . $userId . '&Message=' . $message . '&SmsVendor=' . $vendor,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    public function generateToken($user)
    {
//        $payload = [
//            'iat' => time(),
//            'iss' => $_SERVER['SERVER_NAME'],
//            'exp' => time() + 12 * 30 * (24 * 60 * 60),// 1 Month
//            'ChassisNo' => $user['ChassisNo'],
//            'Id' => $user['Id'],
//            'MobileNo' => $user['MobileNo'],
//        ];
//        try {
//            $privateKey = env('JWT_SECRET',"dEYBNLK7v1AW6vFOhkY15T9Z60mayXHGDrCiAj9aA9UnAnSwrWa7T2m0FmiMNPjd");
//            $token = JWT::encode($payload, $privateKey);
//            return $token;
//        } catch (\Exception $ex) {
//            $token = false;
//        }
//        return $token;
        $user = User::where('ChassisNo', $user['ChassisNo'])->first();
        Auth::login($user);
        return JWTAuth::fromUser($user);

    }

    public function warrantyInfo(Request $request){
        $payload = $this->CustomerInfo($request);
        $userInfo['Id']=$payload['Id'];
        $userInfo['ChassisNo']=$payload['ChassisNo'];
        $userInfo['MobileNo']=$payload['MobileNo'];
        return $userInfo;
    }
}
