<?php

namespace App\Models\JobCard;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealarInvoiceMaster extends Model
{
    use HasFactory;
    protected $table = "DealarInvoiceMaster";
    public $timestamps = false;
    public $primaryKey = 'InvoiceID';
//    protected $keyType = "string";
    protected $guarded = [];

    public function DealarInvoiceDetails(){
        return $this->hasOne(DealarInvoiceDetails::class,'InvoiceID','InvoiceID');
    }

    public function partsDetails() {
        return $this->hasMany(DealarInvoiceDetails::class,'InvoiceID','InvoiceID')
            ->join('Product','Product.ProductCode','DealarInvoiceDetails.ProductCode')
            ->select('DealarInvoiceDetails.InvoiceID','DealarInvoiceDetails.InvDetailsID','DealarInvoiceDetails.ProductCode','Product.ProductName','DealarInvoiceDetails.Quantity',
            'DealarInvoiceDetails.UnitPrice','DealarInvoiceDetails.Discount','DealarInvoiceDetails.VAT');
    }

}
