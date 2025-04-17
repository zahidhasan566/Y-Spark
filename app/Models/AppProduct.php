<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppProduct extends Model
{
    use HasFactory;
    protected $table = "AppProduct";
    public $primaryKey = false;
    public $timestamps = false;
    protected $guarded = [];
}
