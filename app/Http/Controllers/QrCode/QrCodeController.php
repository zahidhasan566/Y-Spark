<?php

namespace App\Http\Controllers\QrCode;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function qrCodeData(Request $request){
        return response()->json([
            'status' => 'success',
            'qrCodeData' => $request->all(),
        ]);
    }
}
