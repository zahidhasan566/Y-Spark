<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblDealarMechanics extends Model
{
    use HasFactory;

    protected $table = "tblDealarMechanics";
    public $timestamps = false;
    public $primaryKey = 'MechanicsID';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
