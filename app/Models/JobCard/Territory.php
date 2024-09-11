<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Territory extends Model
{
    use HasFactory;

    protected $table = "Territory";
    public $timestamps = false;
    public $primaryKey = 'TTYCode';
    protected $guarded = [];
    protected $keyType = "string";
}
