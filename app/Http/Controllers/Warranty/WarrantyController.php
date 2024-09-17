<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function getSupportingData(){
        $warrantyBookUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/warranty.pdf";
        $firstFreeServiceUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/1st+free+service.pdf";
        $secondFreeServiceUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/2nd+free+service.pdf";
        $thirdFreeServiceUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/3rd+free+service.pdf";
        $fourthFreeServiceUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/4th+free+service.pdf";
        $bonusFreeServiceUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/Bonus+free+service.pdf";

        return response()->json([
            'status' => 'success',
            'warrantyBookUrl' => $warrantyBookUrl,
            'firstFreeServiceUrl' => $firstFreeServiceUrl,
            'secondFreeServiceUrl' => $secondFreeServiceUrl,
            'thirdFreeServiceUrl' => $thirdFreeServiceUrl,
            'fourthFreeServiceUrl' => $fourthFreeServiceUrl,
            'bonusFreeServiceUrl' => $bonusFreeServiceUrl,

        ]);

    }
}
