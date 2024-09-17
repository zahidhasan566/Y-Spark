<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewRetailCustomer extends Model
{
    use HasFactory;
    protected $table = "ViewRetailCustomer";
    public $primaryKey = false;
    protected $guarded = [];
    public $timestamps = false;
}
