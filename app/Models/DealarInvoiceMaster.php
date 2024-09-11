<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealarInvoiceMaster extends Model
{
    use HasFactory;
    protected $table = "DealarInvoiceMaster";
    public $primaryKey = 'InvoiceID';
    protected $guarded = [];
    public $timestamps = false;
}
