<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::with('items.itemable')->latest()->get();
        return view('plans.index', compact('plans'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        return view('plans.create', compact('products', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        Plan::create($request->all());
        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function show(Plan $plan)
    {
        $plan->load('items.itemable');
        return view('plans.show', compact('plan'));
    }

    public function edit(Plan $plan)
    {
        $products = Product::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $plan->load('items.itemable');
        return view('plans.edit', compact('plan', 'products', 'services'));
    }

    public function update(Request $request, Plan $plan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $plan->update($request->all());
        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }
}
