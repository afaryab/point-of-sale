<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Bill</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('bills.store') }}" method="POST" x-data="billForm()">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Counter</label>
                            <select name="counter_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">No Counter</option>
                                @foreach($counters as $counter)
                                    <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                                <input type="text" name="customer_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Customer Phone</label>
                                <input type="text" name="customer_phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Payment Type</label>
                            <select name="payment_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="prepaid" {{ $paymentType === 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                                <option value="postpaid" {{ $paymentType === 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold mb-2">Items</h3>
                            <div x-show="items.length === 0" class="text-gray-500 mb-2">No items added yet</div>
                            <template x-for="(item, index) in items" :key="index">
                                <div class="flex gap-2 mb-2">
                                    <input type="hidden" :name="'items[' + index + '][type]'" :value="item.type">
                                    <input type="hidden" :name="'items[' + index + '][id]'" :value="item.id">
                                    <input type="hidden" :name="'items[' + index + '][quantity]'" :value="item.quantity">
                                    <div class="flex-1 border rounded p-2">
                                        <span x-text="item.name"></span> - 
                                        <span x-text="item.quantity"></span> x $<span x-text="item.price"></span>
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                                </div>
                            </template>
                            <div class="grid grid-cols-4 gap-2 mt-4">
                                <select x-model="newItem.type" class="rounded-md border-gray-300 shadow-sm">
                                    <option value="product">Product</option>
                                    <option value="service">Service</option>
                                    <option value="plan">Plan</option>
                                </select>
                                <select x-model="newItem.id" class="rounded-md border-gray-300 shadow-sm">
                                    <template x-if="newItem.type === 'product'">
                                        <optgroup label="Products">
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </template>
                                    <template x-if="newItem.type === 'service'">
                                        <optgroup label="Services">
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}">{{ $service->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </template>
                                    <template x-if="newItem.type === 'plan'">
                                        <optgroup label="Plans">
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->id }}" data-name="{{ $plan->name }}" data-price="{{ $plan->price }}">{{ $plan->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    </template>
                                </select>
                                <input type="number" x-model.number="newItem.quantity" min="1" value="1" class="rounded-md border-gray-300 shadow-sm">
                                <button type="button" @click="addItem()" class="bg-green-500 text-white px-3 py-1 rounded">Add</button>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Bill</button>
                            <a href="{{ route('bills.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function billForm() {
            return {
                items: [],
                newItem: { type: 'product', id: '', quantity: 1 },
                addItem() {
                    if (!this.newItem.id) return;
                    const select = document.querySelector('select[x-model="newItem.id"]');
                    const option = select.options[select.selectedIndex];
                    this.items.push({
                        type: this.newItem.type,
                        id: this.newItem.id,
                        name: option.getAttribute('data-name'),
                        price: option.getAttribute('data-price'),
                        quantity: this.newItem.quantity
                    });
                    this.newItem = { type: 'product', id: '', quantity: 1 };
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
</x-app-layout>
