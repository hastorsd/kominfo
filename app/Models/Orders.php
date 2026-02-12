<?php

namespace App\Models;

use App\Models\Customers;
use App\Models\Employees;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'order_id',
        'customer_id',
        'employee_id',
        'order_date',
        'required_date',
        'shipped_date',
        'ship_via',
        'freight',
        'ship_name',
        'ship_address',
        'ship_city',
        'ship_region',
        'ship_postal_code',
        'ship_country'
    ];

    // customernya
    public function customer(){
        return $this->belongsTo(Customers::class, 'customer_id');
    }
    
    // pegawai minimarketnya
    public function employee() {
        return $this->belongsTo(Employees::class, 'employee_id');
    }

    public function orderDetails(){
        return $this->belongsToMany(Products::class, 'order_details', 'order_id', 'product_id')
                    ->withPivot(['quantity']);
    }
}
