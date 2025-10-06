<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['service', 'serviceProvider', 'user'])
            ->latest('scheduled_at')
            ->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $services = Service::where('is_active', true)->get();
        $serviceProviders = ServiceProvider::where('is_active', true)->get();
        return view('appointments.create', compact('services', 'serviceProviders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_provider_id' => 'nullable|exists:service_providers,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'scheduled_at' => 'required|date|after:now',
            'duration' => 'required|integer|min:1',
        ]);

        Appointment::create(array_merge($request->all(), [
            'user_id' => auth()->id(),
        ]));

        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['service', 'serviceProvider', 'user']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::where('is_active', true)->get();
        $serviceProviders = ServiceProvider::where('is_active', true)->get();
        return view('appointments.edit', compact('appointment', 'services', 'serviceProviders'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'service_provider_id' => 'nullable|exists:service_providers,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
        ]);

        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
