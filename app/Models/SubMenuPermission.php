<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenuPermission extends Model
{
    use HasFactory;
    protected $table = "SubMenuPermission";
    public $primaryKey = false;
    protected $guarded = [];
    public $timestamps = false;
}
