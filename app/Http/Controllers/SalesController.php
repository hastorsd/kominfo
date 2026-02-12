<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index() {
        $sales = Customers::select(
                'customers.customer_id',
                'customers.company_name',
                'customers.country',
                DB::raw('SUM(order_details.quantity * products.unit_price) as total_purchase')
            )
            ->join('orders', 'customers.customer_id', '=', 'orders.customer_id')
            ->join('order_details', 'orders.order_id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.product_id')
            ->groupBy('customers.customer_id', 'customers.company_name', 'customers.country')
            ->orderByDesc('total_purchase')
            ->limit(10)
            ->get();

        return view('sales', compact('sales'));
    }

    // untuk buat api 
    public function store(){

    }

}
