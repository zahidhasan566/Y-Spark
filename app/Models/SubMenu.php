<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    protected $table = "SubMenus";
    public $primaryKey = 'SubMenuID';
    protected $guarded = [];
    public $timestamps = false;
    protected $keyType = 'string';
}
