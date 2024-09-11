<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblWorkSetup extends Model
{
    use HasFactory;

    protected $table = "tblWorkSetup";
    public $timestamps = false;
    public $primaryKey = 'Id';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
