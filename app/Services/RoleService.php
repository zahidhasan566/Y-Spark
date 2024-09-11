<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public static function list()
    {
        return Role::where('RoleID','!=','SuperAdmin')->get();
    }
}