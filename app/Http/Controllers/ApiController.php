<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categories;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    // GET /api/products
    public function index(Request $request){
        $query = Products::query()
            ->join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('suppliers', 'products.supplier_id', '=', 'suppliers.supplier_id')
            ->select(
                'products.product_id',
                'products.product_name',
                'products.supplier_id',
                'products.category_id',
                'products.unit_price',
                'products.units_in_stock',
                'categories.category_name',
                'suppliers.company_name as supplier_name'
            );

        // filter category_id
        if ($request->has('category_id')) {
            $query->where('products.category_id', $request->category_id);
        }

        // filter rentang harga
        if ($request->has('min_price')) {
            $query->where('products.unit_price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('products.unit_price', '<=', $request->max_price);
        }

        // search dengan keyword
        if ($request->has('keyword')) {
            $query->where('products.product_name', 'like', '%' . $request->keyword . '%');
            //('nomor_surat', 'like', "%{$search}%")
        }

        // sort
        $sort = $request->input('sort', 'unit_price:desc');
        $sortParts = explode(':', $sort);
        $sortColumn = $sortParts[0] ?? 'product_id';
        $sortDirection = $sortParts[1] ?? 'asc';
        $query->orderBy('products.' . $sortColumn, $sortDirection);

        // pagination
        $page = $request->input('page', 1);
        $limit = $request->input('limit', 10);
        $total = $query->count();
        $totalPages = ceil($total / $limit);
        $products = $query->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get();

        return response()->json([
            'message' => 'Success',
            'status' => 200,
            'data' => $products,
            'meta' => [
                'pagination' => [
                    'page' => (int) $page,
                    'limit' => (int) $limit,
                    'total' => $total,
                    'total_pages' => $totalPages,
                ],
                'keyword' => $request->get('keyword'),
                'sort' => $sort,
            ]
        ], 200);
    }

    // GET /api/products/{id} (detail)
    public function show($id) {
        // detail produk
        $product = Products::query()
            ->leftJoin('categories', 'products.category_id', '=', 'categories.category_id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.supplier_id')
            ->select(
                'products.*',
                'categories.category_name',
                'categories.description as category_description',
                'suppliers.company_name as supplier_name',
                'suppliers.contact_name as supplier_contact',
                'suppliers.phone as supplier_phone'
            )
            ->where('products.product_id', $id)
            ->first();

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => 404
            ], 404);
        }
            
        // ambil data total terjual quantity
        $totalSold = DB::table('order_details')
            ->where('product_id', $id)
            ->sum('quantity');
            
        return response()->json([
            'product' => $product,
            'total_sold' => $totalSold
        ], 200);
    }

    // GET /api/categories
    public function categories() {
        $categories = DB::table('categories')
            ->select('category_id', 'category_name')
            ->orderBy('category_name')
            ->get();
            
        return response()->json([
            'message' => 'Success',
            'status' => 200,
            'data' => $categories
        ], 200);
    }

    // GET /api/suppliers
    public function suppliers() {
        $suppliers = DB::table('suppliers')
            ->select('supplier_id', 'company_name as supplier_name')
            ->orderBy('company_name')
            ->get();
            
        return response()->json([
            'message' => 'Success',
            'status' => 200,
            'data' => $suppliers
        ], 200);
    }
}
