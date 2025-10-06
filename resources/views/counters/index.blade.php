<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Counters
            </h2>
            <a href="{{ route('counters.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Counter
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($counters as $counter)
                            <div class="border rounded p-4">
                                <h3 class="font-bold text-lg">{{ $counter->name }}</h3>
                                <p class="text-sm text-gray-600">Status: 
                                    <span class="font-semibold {{ $counter->status === 'open' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($counter->status) }}
                                    </span>
                                </p>
                                @if($counter->user)
                                    <p class="text-sm text-gray-600">Operator: {{ $counter->user->name }}</p>
                                @endif
                                @if($counter->opened_at)
                                    <p class="text-sm text-gray-600">Opened: {{ $counter->opened_at->format('M d, Y H:i') }}</p>
                                @endif
                                
                                <div class="mt-4 flex gap-2">
                                    @if($counter->status === 'closed')
                                        <form action="{{ route('counters.open', $counter) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Open
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('counters.close', $counter) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Close
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('counters.edit', $counter) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
