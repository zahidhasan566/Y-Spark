<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblJobCardProblemDetails extends Model
{
    use HasFactory;
    protected $table = "tblJobCardProblemDetails";
    public $timestamps = false;
    public $primaryKey = 'ProblemDetailsId';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
