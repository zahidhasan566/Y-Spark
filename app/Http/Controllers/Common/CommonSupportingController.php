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
        return response()->json([
            'status' => 'success',
            'partsMrpUrl' => $partsMrpUrl,
            'socialLink' => $socialLink,
        ]);
    }
}
