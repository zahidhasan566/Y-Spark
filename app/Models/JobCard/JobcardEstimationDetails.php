<?php

namespace App\Models\JobCard;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobcardEstimationDetails extends Model
{
    use HasFactory;
    protected $table = "JobcardEstimationDetails";
    public $timestamps = false;
    public $primaryKey = false;
    public $incrementing = false;
    protected $keyType = "string";
    protected $guarded = [];
    public function Product(){
        return $this->belongsTo(Product::class,'ItemCode','ProductCode');
    }
}
