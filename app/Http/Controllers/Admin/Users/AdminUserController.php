<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\SubMenuPermission;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $take = $request->take;
        $search = $request->search;
        $users=  User::join('Roles', 'Roles.RoleID', 'Users.RoleID')
            ->where(function ($q) use ($search) {
                $q->where('Name', 'like', '%' . $search . '%');
                $q->orWhere('Id', 'like', '%' . $search . '%');
            })
            ->where('Users.RoleID', '!=', 'SuperAdmin')
            ->orderBy('Id', 'asc')
            ->select('Id', 'Name', 'Email','Mobile','NID', 'Address', 'Roles.RoleName as Role')
            ->paginate($take);
        return $users;
    }

    //Initial List View
    public function userModalData(){
        return response()->json([
            'status' => 'success',
            'roles' => RoleService::list(),
            'allSubMenus' => Menu::whereNotIn('MenuID',['Dashboard','Users'])->with('allSubMenus')->orderBy('MenuOrder','asc')->get()
        ]);
    }

    //Store Data
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'Name' => 'required|string',
            'email' => 'required',
            'Address' => 'required',
            'NID' => 'required',
            'mobile' => 'required',
            'userType' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        //Data Insert
        try {
            DB::beginTransaction();
            $user = new User();
            $user->Name = $request->Name;
            $user->Email = $request->email;
            $user->Mobile = $request->mobile;
            $user->Address = $request->Address;
            $user->NID = $request->NID;
            $user->RawPassword = ($request->password);
            $user->Password = bcrypt($request->password);
            $user->RoleID = $request->userType['RoleID'];
            $user->Status = $request->status;
            $user->CreatedBy = Auth::user()->Id;
            $user->UpdatedBy = Auth::user()->Id;
            $user->CreatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $user->UpdatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();

            $submenus = [];
            foreach ($request->selectedSubMenu as $row) {
                $submenus[] = [
                    'UserId' => Auth::user()->Id,
                    'SubMenuID' => $row
                ];
            }
            SubMenuPermission::insert($submenus);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'User Created Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage() . '-' . $exception->getLine()
            ], 500);
        }
    }

    //Get Existing User Info
    public function getUserInfo($Id){
        $user = User::where('Id', $Id)->with(['roles', 'userSubmenu'])->first();
        $allSubMenus = Menu::whereNotIn('MenuID', ['Dashboard', 'Users'])->with('allSubMenus')->orderBy('MenuOrder', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'allSubMenus' => $allSubMenus
        ]);
    }

    //Update User
    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'Name' => 'required|string',
            'email' => 'required',
            'Address' => 'required',
            'NID' => 'required',
            'mobile' => 'required',
            'userType' => 'required',
            'status' => 'required',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 400);
        }
        try {
            DB::beginTransaction();
            $user = User::where('Id', $request->UserId)->first();
            $user->Name = $request->Name;
            $user->Email = $request->email;
            $user->Mobile = $request->mobile;
            $user->Address = $request->Address;
            $user->NID = $request->NID;
            $user->RawPassword = ($request->password);
            $user->Password = bcrypt($request->password);
            $user->RoleID = $request->userType['RoleID'];
            $user->Status = $request->status;
            $user->CreatedBy =$request->UserId;
            $user->UpdatedBy =$request->UserId;
            $user->CreatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $user->UpdatedAt = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();

            //submenu permission delete
            SubMenuPermission::where('UserId', Auth::user()->Id)->delete();

            $submenus = [];
            foreach ($request->selectedSubMenu as $row) {
                $submenus[] = [
                    'UserId' => $request->UserId,
                    'SubMenuID' => $row
                ];
            }
            SubMenuPermission::insert($submenus);
            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'User Updated Successfully'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }

    }

}
