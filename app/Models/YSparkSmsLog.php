<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YSparkSmsLog extends Model
{
    use HasFactory;
    protected $table = "YSparkSmsLog";
    public $primaryKey = 'SmsLogID';
    protected $guarded = [];
    public $timestamps = false;
}
