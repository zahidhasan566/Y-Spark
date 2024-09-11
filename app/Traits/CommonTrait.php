<?php

namespace App\Traits;



use App\Services\RoleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Tymon\JWTAuth\Facades\JWTAuth;

trait CommonTrait
{

    public function CustomerInfo($request){
        $token = $request->bearerToken();
        $payload = JWTAuth::setToken($token)->getPayload();
        return $payload;
    }

}
