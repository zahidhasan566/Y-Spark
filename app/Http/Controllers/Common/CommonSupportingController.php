<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\YSparkEvents;
use Illuminate\Http\Request;

class CommonSupportingController extends Controller
{
    public function getSupportingData(Request $request){
        $partsMrpUrl = "https://acimotors-bd.com/products/automobiles/yamaha/accessories";
        $socialLink=[];
        $socialLink['facebook'] = "https://www.facebook.com/Yamahabd";
        $socialLink['instagram'] = "https://www.instagram.com/yamaha.bangladesh";
        $socialLink['tiktok'] = "https://www.tiktok.com/@yamaha.bangladesh";
        $socialLink['autoMobile'] = "https://acimotors-bd.com/products/automobiles/yamaha";
        $socialLink['youtube'] = "https://www.youtube.com/@YAMAHABangladesh";
        $socialLink['callCenter'] = "16533";

        $eventsArr = YSparkEvents::where('Status', 1)->get();
        $allEvents =[];
        $finalEvents =[];

        foreach($eventsArr as $event){
            $finalEvents['EventID']=$event->EventID;
            $finalEvents['EventName']=$event->EventName;
            $finalEvents['EventImage']= public_path('assets/images/events'.$event->EventImage);;
            $finalEvents['EventStartFrom']=$event->EventStartFrom;
            $finalEvents['EventEndTo']=$event->EventEndTo;
            $finalEvents['EventDetails']=$event->EventDetails;
            array_push($allEvents,$finalEvents);
        }



        return response()->json([
            'status' => 'success',
            'partsMrpUrl' => $partsMrpUrl,
            'socialLink' => $socialLink,
            'allEvents' => $allEvents,
        ]);
    }
}
