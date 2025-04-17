<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProductCategory extends Model
{
    use HasFactory;
    protected $table = "AppProductCategory";
    public $primaryKey = 'CategoryID';
    public $timestamps = false;
    protected $guarded = [];
}
