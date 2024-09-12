<?php

namespace App\Http\Controllers\Warranty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function getSupportingData(){
        $warrantyBookUrl = "https://yspark.s3.ap-southeast-1.amazonaws.com/warranty/warranty.pdf";

        return response()->json([
            'status' => 'success',
            'warrantyBookUrl' => $warrantyBookUrl
        ]);

    }
}
