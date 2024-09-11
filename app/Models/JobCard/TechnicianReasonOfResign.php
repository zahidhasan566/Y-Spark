<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianReasonOfResign extends Model
{
    use HasFactory;

    protected $table = "TechnicianReasonOfResign";
    public $timestamps = false;
    public $primaryKey = 'Id';
    protected $guarded = [];
}
