<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = "Roles";
    public $timestamps = false;
    public $primaryKey = "RoleID";
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
