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
    public function getBikeModels(){
        $data = [];
        $data['success'] = 0;

        $data['BikeModel'] = [];

        $data['BikeModel'] = DB::connection('sqlsrv62')->select("SELECT * FROM BikeModel WHERE Active='Y'");

        if ($data['BikeModel']) {
            $data['success'] = 1;

        }
        return json_encode($data);
    }

    public function getYamalube(){
        $data = [];
        $data['success'] = 0;

        $data['YamaLube'] = [];

        $data['YamaLube'] = DB::connection('sqlsrv62')->select("SELECT
					Y.YamaLubeID,YamaLubeName,ChangingInterval,MRP,Photo AS Image,Thumb,BikeModel
				FROM YamaLube Y
					INNER JOIN (
							SELECT DISTINCT YamaLubeID ,
							STUFF((SELECT ', ' + CONVERT(VARCHAR(50) , BikeModelName)
							FROM (
								SELECT
									YamaLubeID,
									BikeModelName
								FROM YamaLubeBikeModel M
								INNER JOIN BikeModel B
									ON M.BikeModelID = B.BikeModelID
							) T1
							where T1.YamaLubeID = T2.YamaLubeID
							FOR XML PATH('')),1,1,'') AS BikeModel
							from (
								SELECT
									YamaLubeID,
									BikeModelName
								FROM YamaLubeBikeModel M
								INNER JOIN BikeModel B
									ON M.BikeModelID = B.BikeModelID
							) T2
						) LD
						ON Y.YamaLubeID = LD.YamaLubeID
						WHERE active='Y'");

        if ($data['YamaLube']) {
            $data['success'] = 1;

        }
        return json_encode($data);
    }

    public function getAccessoriesHelmet(){
        $data = [];
        $data['success'] = 0;

        $data['Parts'] = [];

        $data['Parts'] = DB::connection('sqlsrv62')->select("SELECT * FROM AccessoriesHelmet WHERE active='Y'");

        if ($data['Parts']) {
            $data['success'] = 1;

        }
        return json_encode($data);
    }
}
