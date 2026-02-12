<?php

namespace App\Models;

use App\Models\Categories;
use App\Models\Suppliers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'product_id',
        'product_name',
        'supplier_id',
        'category_id',
        'quantity_per_unit',
        'unit_price',
        'units_in_stock',
        'units_on_order',
        'reorder_level',
        'discontinued'
    ];

    public function supplier() {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }

    public function category(){
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
