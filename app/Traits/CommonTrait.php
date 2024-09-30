<?php

namespace App\Traits;



use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Tymon\JWTAuth\Facades\JWTAuth;

trait CommonTrait
{

    public function CustomerInfo($request){
//        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        return $payload;
    }
    public function sendSmsQ($to, $sId, $applicationName, $moduleName, $otherInfo, $userId, $vendor, $message)
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

}
