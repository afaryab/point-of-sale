<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function index()
    {
        $serviceProviders = ServiceProvider::latest()->get();
        return view('admin.service-providers.index', compact('serviceProviders'));
    }

    public function create()
    {
        return view('admin.service-providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:service_providers',
            'phone' => 'nullable|string|max:255',
        ]);

        ServiceProvider::create($request->all());
        return redirect()->route('admin.service-providers.index')->with('success', 'Service provider created successfully.');
    }

    public function show(ServiceProvider $serviceProvider)
    {
        return view('admin.service-providers.show', compact('serviceProvider'));
    }

    public function edit(ServiceProvider $serviceProvider)
    {
        return view('admin.service-providers.edit', compact('serviceProvider'));
    }

    public function update(Request $request, ServiceProvider $serviceProvider)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:service_providers,email,' . $serviceProvider->id,
            'phone' => 'nullable|string|max:255',
        ]);

        $serviceProvider->update($request->all());
        return redirect()->route('admin.service-providers.index')->with('success', 'Service provider updated successfully.');
    }

    public function destroy(ServiceProvider $serviceProvider)
    {
        $serviceProvider->delete();
        return redirect()->route('admin.service-providers.index')->with('success', 'Service provider deleted successfully.');
    }
}
