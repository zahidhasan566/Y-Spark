<?php

namespace App\Http\Controllers\ServiceHistory;

use App\Http\Controllers\Controller;
use App\Models\JobCard\FreeServiceSchedule;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Models\JobCard\TblJobCard;
use Illuminate\Support\Facades\DB;

class ServiceHistoryController extends Controller
{
    use CommonTrait;
    public function getServiceHistory(Request $request){
        $payload = $this->CustomerInfo($request);
        $id=$payload['Id'];
        $chassisNo = $payload['ChassisNo'];
        $mobileNo =$payload['MobileNo'];

        $serviceHistory =  DB::select("exec usp_doLoadServiceHistoriesNew '$chassisNo'");
        $serviceSchedule = FreeServiceSchedule::where('ChassisNo', $chassisNo)->get();
        return response()->json([
            'status' => 'Success',
            'serviceHistory' =>$serviceHistory,
            'serviceSchedule' =>$serviceSchedule,
        ], 200);

    }
}
