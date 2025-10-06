<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Product;
use App\Models\Service;
use App\Models\Plan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $counters = Counter::where('status', 'open')->with('user')->get();
        $products = Product::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $plans = Plan::where('is_active', true)->with('items.itemable')->get();
        
        return view('dashboard', compact('counters', 'products', 'services', 'plans'));
    }
}
