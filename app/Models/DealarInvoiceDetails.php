<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealarInvoiceDetails extends Model
{
    use HasFactory;
    protected $table = "DealarInvoiceDetails";
    public $primaryKey = 'InvDetailsID';
    protected $guarded = [];
    public $timestamps = false;
}
