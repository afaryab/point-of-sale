<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::with('user')->latest()->get();
        return view('counters.index', compact('counters'));
    }

    public function create()
    {
        return view('counters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Counter::create([
            'name' => $request->name,
            'status' => 'closed',
        ]);

        return redirect()->route('counters.index')->with('success', 'Counter created successfully.');
    }

    public function show(Counter $counter)
    {
        $counter->load('user');
        return view('counters.show', compact('counter'));
    }

    public function edit(Counter $counter)
    {
        return view('counters.edit', compact('counter'));
    }

    public function update(Request $request, Counter $counter)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $counter->update([
            'name' => $request->name,
        ]);

        return redirect()->route('counters.index')->with('success', 'Counter updated successfully.');
    }

    public function destroy(Counter $counter)
    {
        $counter->delete();
        return redirect()->route('counters.index')->with('success', 'Counter deleted successfully.');
    }

    public function open(Counter $counter)
    {
        if ($counter->status === 'open') {
            return back()->with('error', 'Counter is already open.');
        }

        $counter->update([
            'status' => 'open',
            'user_id' => auth()->id(),
            'opened_at' => now(),
        ]);

        return back()->with('success', 'Counter opened successfully.');
    }

    public function close(Counter $counter)
    {
        if ($counter->status === 'closed') {
            return back()->with('error', 'Counter is already closed.');
        }

        $counter->update([
            'status' => 'closed',
            'closed_at' => now(),
        ]);

        return back()->with('success', 'Counter closed successfully.');
    }
}
