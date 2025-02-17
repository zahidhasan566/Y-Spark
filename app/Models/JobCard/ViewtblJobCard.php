<?php

namespace App\Models\Jobcard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewtblJobCard extends Model
{
    use HasFactory;

    protected $table = "ViewtblJobCard";
    public $timestamps = false;
    public $primaryKey = 'JobCardNo';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
