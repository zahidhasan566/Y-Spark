<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblJobCardProblemStatement extends Model
{
    use HasFactory;

    protected $table = "tblJobCardProblemStatement";
    public $timestamps = false;
    public $primaryKey = 'PSID';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
