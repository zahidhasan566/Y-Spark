<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobcardEstimation extends Model
{
    use HasFactory;
    protected $table = "JobcardEstimation";
    public $timestamps = false;
    public $primaryKey = 'EstimationNo';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];

    public function JobcardEstimationDetails(){
        return $this->hasMany(JobcardEstimationDetails::class,'EstimationNo','EstimationNo');
    }
}
