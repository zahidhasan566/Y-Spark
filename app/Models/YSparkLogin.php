<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YSparkLogin extends Model
{
    use HasFactory;
    protected $table = "YSparkLogin";
    public $primaryKey = 'Id';
    protected $guarded = [];
    public $timestamps = false;


}
