<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiController extends Controller
{
    // GET /api/products
    public function index(){
        $products = response()->json(Products::all());

        return response([
            'message' => 'Success',
            'status' => 200,
            'data' => $products
        ], 200);
    }

    // GET /api/products/{id} (detail)
    public function show($id) {
        $product = Products::findOrFail($id);
        return response()->json($product);
    }
}
