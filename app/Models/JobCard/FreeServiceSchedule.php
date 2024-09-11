<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeServiceSchedule extends Model
{
    use HasFactory;
    protected $table = "FreeServiceSchedule";
    public $timestamps = false;
    public $primaryKey = 'FreeSScheduleID';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
