<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblDealarAffiliator extends Model
{
    use HasFactory;

    protected $table = "tblDealarAffiliator";
    public $timestamps = false;
    public $primaryKey = 'AffiliatorID';
    protected $guarded = [];
}
