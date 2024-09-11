<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineReservation extends Model
{
    use HasFactory;
    protected $table = "OnlineReservation";
    public $timestamps = false;
    public $primaryKey = 'CustomerCode';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
