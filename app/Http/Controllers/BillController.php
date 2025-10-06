<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Counter;
use App\Models\Product;
use App\Models\Service;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with(['counter', 'user', 'items'])->latest()->get();
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $counters = Counter::where('status', 'open')->get();
        $products = Product::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        $plans = Plan::where('is_active', true)->get();
        
        $defaultPaymentType = Setting::where('key', 'default_payment_type')->first();
        $paymentType = $defaultPaymentType ? $defaultPaymentType->value : 'prepaid';
        
        return view('bills.create', compact('counters', 'products', 'services', 'plans', 'paymentType'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'counter_id' => 'nullable|exists:counters,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.type' => 'required|in:product,service,plan',
            'items.*.id' => 'required|integer',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $subtotal = 0;
        $billItems = [];

        foreach ($request->items as $item) {
            $itemable = null;
            
            switch ($item['type']) {
                case 'product':
                    $itemable = Product::findOrFail($item['id']);
                    break;
                case 'service':
                    $itemable = Service::findOrFail($item['id']);
                    break;
                case 'plan':
                    $itemable = Plan::findOrFail($item['id']);
                    break;
            }

            $price = $itemable->price;
            $total = $price * $item['quantity'];
            $subtotal += $total;

            $billItems[] = [
                'itemable_type' => get_class($itemable),
                'itemable_id' => $itemable->id,
                'name' => $itemable->name,
                'quantity' => $item['quantity'],
                'price' => $price,
                'total' => $total,
            ];
        }

        $bill = Bill::create([
            'counter_id' => $request->counter_id,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'subtotal' => $subtotal,
            'tax' => 0,
            'discount' => 0,
            'total' => $subtotal,
            'payment_type' => $request->payment_type ?? 'prepaid',
            'status' => $request->payment_type === 'prepaid' ? 'pending' : 'pending',
        ]);

        foreach ($billItems as $billItem) {
            $bill->items()->create($billItem);
        }

        return redirect()->route('bills.show', $bill)->with('success', 'Bill created successfully.');
    }

    public function show(Bill $bill)
    {
        $bill->load(['counter', 'user', 'items.itemable']);
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        $counters = Counter::where('status', 'open')->get();
        $bill->load('items.itemable');
        return view('bills.edit', compact('bill', 'counters'));
    }

    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,cancelled',
        ]);

        $updateData = ['status' => $request->status];
        
        if ($request->status === 'paid') {
            $updateData['paid_at'] = now();
        }

        $bill->update($updateData);
        return redirect()->route('bills.show', $bill)->with('success', 'Bill updated successfully.');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Bill deleted successfully.');
    }
}
