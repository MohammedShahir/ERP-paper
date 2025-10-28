<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'customers' => Customer::count(),
            'sales' => Sale::count(),
            'revenue' => (float) Sale::sum('total'),
        ];

        $recentSales = Sale::with('customer')->latest()->take(5)->get();
        $lowStock = Product::orderBy('stock', 'asc')->take(5)->get();

        return view('dashboard', compact('stats', 'recentSales', 'lowStock'));
    }
}
