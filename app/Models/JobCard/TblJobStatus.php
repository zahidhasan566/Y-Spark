<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblJobStatus extends Model
{
    use HasFactory;

    protected $table = "TblJobStatus";
    public $timestamps = false;
    public $primaryKey = 'StatusCode';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
