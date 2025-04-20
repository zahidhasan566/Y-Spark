<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\AppProduct;
use App\Models\AppProductCategory;
use App\Models\YSparkEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonSupportingController extends Controller
{
    public function getSupportingData(Request $request){
        $socialLink=[];
        $socialLink['facebook'] = "https://www.facebook.com/Yamahabd";
        $socialLink['instagram'] = "https://www.instagram.com/yamaha.bangladesh";
        $socialLink['tiktok'] = "https://www.tiktok.com/@yamaha.bangladesh";
        $socialLink['autoMobile'] = "https://acimotors-bd.com/products/automobiles/yamaha";
        $socialLink['youtube'] = "https://www.youtube.com/@YAMAHABangladesh";
        $socialLink['callCenter'] = "16533";
        return response()->json([
            'status' => 'success',
            'socialLink' => $socialLink,
        ]);
    }

    public function getSparePartsCategoryData(){
        $data = AppProductCategory::all();
        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    //Get Spare Parts Data
    public function getSparePartsData(Request $request){
        $validator = Validator::make($request->all(), [
            'CategoryID' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        $search = $request->Search;
        $product  = AppProduct::select('AppProductCategory.CategoryID','AppProductCategory.CategoryName',
            'Product.ProductCode','Product.ProductName','Product.MRP','AppProduct.Image','AppProduct.Type')
            ->join('AppProductCategory','AppProductCategory.CategoryID','=','AppProduct.CategoryID')
            ->join('Product','Product.ProductCode','=','AppProduct.ProductCode')
            ->where('AppProduct.CategoryID', $request->CategoryID)
            ->where(function ($q) use ($search) {
                $q->where('Product.ProductName', 'like', '%' . $search . '%');
                $q->orWhere('Product.ProductCode', 'like', '%' . $search . '%');
            })
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $product,
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
