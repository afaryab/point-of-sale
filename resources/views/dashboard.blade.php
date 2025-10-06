<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Quick Actions -->
            <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="{{ route('bills.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded text-center">
                    New Bill
                </a>
                <a href="{{ route('appointments.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-4 px-4 rounded text-center">
                    New Appointment
                </a>
                <a href="{{ route('counters.index') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-4 px-4 rounded text-center">
                    Manage Counters
                </a>
                <a href="{{ route('products.index') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-4 px-4 rounded text-center">
                    Manage Inventory
                </a>
            </div>

            <!-- Counters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Open Counters</h3>
                    @if($counters->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($counters as $counter)
                                <div class="border rounded p-4">
                                    <h4 class="font-bold">{{ $counter->name }}</h4>
                                    <p class="text-sm text-gray-600">Operator: {{ $counter->user->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">Opened: {{ $counter->opened_at?->format('M d, Y H:i') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No counters are currently open.</p>
                    @endif
                </div>
            </div>

            <!-- Products, Services, Plans -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Products -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Products ({{ $products->count() }})</h3>
                        <div class="space-y-2">
                            @foreach($products->take(5) as $product)
                                <div class="flex justify-between items-center">
                                    <span>{{ $product->name }}</span>
                                    <span class="text-sm text-gray-600">{{ $product->quantity }} in stock</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('products.index') }}" class="text-blue-500 text-sm mt-2 inline-block">View all →</a>
                    </div>
                </div>

                <!-- Services -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Services ({{ $services->count() }})</h3>
                        <div class="space-y-2">
                            @foreach($services->take(5) as $service)
                                <div class="flex justify-between items-center">
                                    <span>{{ $service->name }}</span>
                                    <span class="text-sm text-gray-600">{{ $service->duration }}min</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('services.index') }}" class="text-blue-500 text-sm mt-2 inline-block">View all →</a>
                    </div>
                </div>

                <!-- Plans -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Plans ({{ $plans->count() }})</h3>
                        <div class="space-y-2">
                            @foreach($plans->take(5) as $plan)
                                <div class="flex justify-between items-center">
                                    <span>{{ $plan->name }}</span>
                                    <span class="text-sm text-gray-600">${{ number_format($plan->price, 2) }}</span>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('plans.index') }}" class="text-blue-500 text-sm mt-2 inline-block">View all →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
