<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineReservationDetails extends Model
{
    use HasFactory;
    protected $table = "OnlineReservationDetails";
    public $timestamps = false;
    public $primaryKey = 'CustomerCode';
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
}
