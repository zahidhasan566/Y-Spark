<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidServiceSchedule extends Model
{
    use HasFactory;
    protected $table = "PaidServiceSchedule";
    public $timestamps = false;
    public $primaryKey = 'PaidSScheduleID';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
