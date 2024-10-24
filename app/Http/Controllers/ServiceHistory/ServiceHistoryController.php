<?php

namespace App\Http\Controllers\ServiceHistory;

use App\Http\Controllers\Controller;
use App\Models\JobCard\FreeServiceSchedule;
use App\Traits\CommonTrait;
use Illuminate\Http\Request;
use App\Models\JobCard\TblJobCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceHistoryController extends Controller
{
    use CommonTrait;

    public function getServiceHistory(Request $request)
    {
        $auth = Auth::user();
        $chassisNo = $auth->ChassisNo;
        $serviceHistory = DB::select("exec usp_doLoadServiceHistoriesNew '$chassisNo'");
        $ytdFileCount = array_reduce($serviceHistory, function ($carry, $item) {
            return $carry + (int)$item->YTD_File;
        }, 0);

        return response()->json([
            'status' => 'Success',
            'ytdFileCount' => $ytdFileCount,
            'serviceHistory' => $serviceHistory,
        ], 200);

    }

    public function getServiceSchedule(Request $request)
    {
        $auth = Auth::user();
        $chassisNo = $auth->ChassisNo;

        $serviceSchedule = FreeServiceSchedule::where('ChassisNo', $chassisNo)->get();
        return response()->json([
            'status' => 'Success',
            'serviceSchedule' => $serviceSchedule,
        ], 200);

    }

    public function customerFeedbackAdd(Request $request)
    {
        TblJobCard::where('JobCardNo', $request->jobCardNo)->update([
                    'CustomerFeedback' => $request->feedbackRating
        ]);
        try {
            return response()->json([
                'status' => 'Success',
                'message' => 'Job Card rating updated successfully',
            ], 200);
        } catch
        (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . '-' . $exception->getLine()
            ], 500);
        }


    }
}
