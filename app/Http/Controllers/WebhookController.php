<?php

namespace App\Http\Controllers;

use App\Models\Webhook;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function index()
    {
        $webhooks = Webhook::latest()->get();
        return view('admin.webhooks.index', compact('webhooks'));
    }

    public function create()
    {
        return view('admin.webhooks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'event' => 'required|string',
        ]);

        Webhook::create($request->all());
        return redirect()->route('admin.webhooks.index')->with('success', 'Webhook created successfully.');
    }

    public function edit(Webhook $webhook)
    {
        return view('admin.webhooks.edit', compact('webhook'));
    }

    public function update(Request $request, Webhook $webhook)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
            'event' => 'required|string',
        ]);

        $webhook->update($request->all());
        return redirect()->route('admin.webhooks.index')->with('success', 'Webhook updated successfully.');
    }

    public function destroy(Webhook $webhook)
    {
        $webhook->delete();
        return redirect()->route('admin.webhooks.index')->with('success', 'Webhook deleted successfully.');
    }
}
