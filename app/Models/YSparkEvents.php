<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YSparkEvents extends Model
{
    use HasFactory;
    protected $table = "YSparkEvents";
    public $primaryKey = 'EventID';
    protected $guarded = [];
    public $timestamps = false;
}
