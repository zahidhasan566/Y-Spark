<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnDealarInvoiceLog extends Model
{
    use HasFactory;
    protected $table = "ReturnDealarInvoiceLog";
    public $primaryKey = 'InvoiceLogID';
    public $timestamps = false;
    protected $guarded = [];
}
