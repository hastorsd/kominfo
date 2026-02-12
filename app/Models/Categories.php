<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'category_id',
        'category_name',
        'description',
        'picture'
    ];
}
