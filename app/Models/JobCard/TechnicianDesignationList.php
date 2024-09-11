<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicianDesignationList extends Model
{
    use HasFactory;

    protected $table = "TechnicianDesignationList";
    public $timestamps = false;
    public $primaryKey = 'Id';
    protected $guarded = [];
}
