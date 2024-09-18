<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\YSparkEvents;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getSupportingData(Request $request){
        $eventsArr = YSparkEvents::where('Status', 1)->get();
        $allEvents =[];
        $finalEvents =[];

        foreach($eventsArr as $event){
            $finalEvents['EventID']=$event->EventID;
            $finalEvents['EventName']=$event->EventName;
            $finalEvents['EventImage']= asset('assets/images/events/'.$event->EventImage);
            $finalEvents['EventStartFrom']=$event->EventStartFrom;
            $finalEvents['EventEndTo']=$event->EventEndTo;
            $finalEvents['EventDetails']=$event->EventDetails;
            array_push($allEvents,$finalEvents);
        }



        return response()->json([
            'status' => 'success',
            'allEvents' => $allEvents,
        ]);
    }
}
