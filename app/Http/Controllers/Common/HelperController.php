<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HelperController extends Controller
{
    public function appSupportingData()
    {
        try {
            $auth = Auth::user();
            $query = Menu::select('Menus.*');
            $data = $query->with('subMenus')
                ->orderBy('MenuOrder','asc')
                ->get();
            return response()->json([
                'status' => 'success',
                'menus' => $data,
                'user' => User::where('Id',Auth::user()->Id)->with('roles')->first(),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function passwordChange(Request $request)
    {

        if($request->updatePassword ===$request->confirmUpdatePassword){
            try{
                $validator = Validator::make($request->all(), [
                    'updatePassword' => 'required|string|min:6',
                    'confirmUpdatePassword' => 'required|string|min:6',
                ]);
                if ($validator->fails()) {
                    return response()->json(['message' => $validator->errors()], 400);
                }
                $user = User::where('id', Auth::user()->Id)->first();
                $user->Password = bcrypt($request->updatePassword);
                $user->RawPassword = $request->updatePassword;
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Password Updated Successfully'
                ]);
            }
            catch (\Exception $exception){
                return response()->json([
                    'status' => 'error',
                    'message' => $exception->getMessage()
                ], 500);
            }
        }
        else{
            return response()->json(['message' => 'Password did not match'], 400);
        }
    }


}
