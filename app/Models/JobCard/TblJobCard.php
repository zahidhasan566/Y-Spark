<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblJobCard extends Model
{
    use HasFactory;

    protected $table = "tblJobCard";
    public $timestamps = false;
    public $primaryKey = 'JobCardNo';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];

//    public function sparePartsService()
//    {
//        return $this->hasMany(TblJobCardDetailSparepartWork::class,'JobCardNo','JobCardNo');
//    }
//    public function sparePartsServicePart()
//    {
//        return $this->hasMany(TblJobCardDetailSparepartWork::class,'JobCardNo','JobCardNo')
//            ->where('ItemType','work');
//    }
//    public function sparePartsServiceWork()
//    {
//        return $this->hasMany(TblJobCardDetailSparepartWork::class,'JobCardNo','JobCardNo')
//            ->where('ItemType','work');
//    }
    public function problemDetails()
    {
        return $this->hasMany(TblJobCardProblemDetails::class,'JobCardNo','JobCardNo');
    }
}
