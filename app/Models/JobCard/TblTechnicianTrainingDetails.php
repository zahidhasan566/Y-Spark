<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblTechnicianTrainingDetails extends Model
{
    use HasFactory;
    protected $table = "tblTechnicianTrainingDetails";
    public $timestamps = false;
    public $incrementing=true;
    public $primaryKey = 'Id';
    protected $guarded = [];
}
