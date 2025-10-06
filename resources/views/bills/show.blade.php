<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bill #{{ $bill->id }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4">
                        <p><strong>Customer:</strong> {{ $bill->customer_name ?? 'Walk-in' }}</p>
                        <p><strong>Payment Type:</strong> {{ ucfirst($bill->payment_type) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($bill->status) }}</p>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Items</h3>
                    <table class="min-w-full mb-4">
                        <thead>
                            <tr>
                                <th class="text-left">Item</th>
                                <th class="text-right">Quantity</th>
                                <th class="text-right">Price</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td class="text-right">{{ $item->quantity }}</td>
                                    <td class="text-right">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-right">${{ number_format($item->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-bold">
                                <td colspan="3" class="text-right">Total:</td>
                                <td class="text-right">${{ number_format($bill->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    @if($bill->status === 'pending')
                        <form action="{{ route('bills.update', $bill) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Mark as Paid
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
