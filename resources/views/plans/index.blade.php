<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Plans</h2>
            <a href="{{ route('plans.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add Plan</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($plans as $plan)
                            <div class="border rounded p-4">
                                <h3 class="font-bold text-lg">{{ $plan->name }}</h3>
                                <p class="text-gray-600">{{ $plan->description }}</p>
                                <p class="text-xl font-bold mt-2">${{ number_format($plan->price, 2) }}</p>
                                <a href="{{ route('plans.edit', $plan) }}" class="text-blue-600 mt-2 inline-block">Edit</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
