<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealarInvoiceDetails extends Model
{
    use HasFactory;
    protected $table = "DealarInvoiceDetails";
    public $primaryKey = 'InvDetailsID';
    public $timestamps = false;
    protected $guarded = [];
}
