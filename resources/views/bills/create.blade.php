<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Bill</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
            <form action="{{ route('bills.store') }}" method="POST" x-data="billForm()">
                @csrf
                <!-- Customer Section: Top 50% -->
                <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3">
                        <h3 class="text-lg font-semibold text-white">Customer Information</h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Left 50%: Customer Form -->
                            <div class="space-y-3">
                                <input type="hidden" name="customer_id" x-model="selectedCustomer.id">
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           name="customer_name" 
                                           x-model="selectedCustomer.name"
                                           @input="searchCustomers()"
                                           required
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                        <select name="customer_gender" 
                                                x-model="selectedCustomer.gender"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Relation Type</label>
                                        <select name="customer_relation_type" 
                                                x-model="selectedCustomer.relation_type"
                                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">Select</option>
                                            <option value="S/O">S/O</option>
                                            <option value="D/O">D/O</option>
                                            <option value="W/O">W/O</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Relation Name</label>
                                    <input type="text" 
                                           name="customer_relation_name" 
                                           x-model="selectedCustomer.relation_name"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                        <input type="text" 
                                               name="customer_phone" 
                                               x-model="selectedCustomer.phone"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CNIC</label>
                                        <input type="text" 
                                               name="customer_cnic" 
                                               x-model="selectedCustomer.cnic"
                                               placeholder="XXXXX-XXXXXXX-X"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                        <input type="date" 
                                               name="customer_dob" 
                                               x-model="selectedCustomer.date_of_birth"
                                               @change="calculateAge()"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                        <input type="number" 
                                               name="customer_age" 
                                               x-model="selectedCustomer.age"
                                               min="0" 
                                               max="150"
                                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Right 50%: Customer Search Results -->
                            <div class="border-l pl-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Search Results</h4>
                                <div class="max-h-64 overflow-y-auto space-y-2">
                                    <template x-if="searchResults.length === 0 && searchQuery.length > 0">
                                        <p class="text-sm text-gray-500 italic">No customers found</p>
                                    </template>
                                    <template x-if="searchResults.length === 0 && searchQuery.length === 0">
                                        <p class="text-sm text-gray-500 italic">Type customer name to search...</p>
                                    </template>
                                    <template x-for="customer in searchResults" :key="customer.id">
                                        <div @click="selectCustomer(customer)"
                                             class="p-3 bg-gray-50 hover:bg-blue-50 rounded-lg cursor-pointer border border-gray-200 hover:border-blue-300 transition">
                                            <div class="font-medium text-gray-900" x-text="customer.name"></div>
                                            <div class="text-xs text-gray-600 mt-1">
                                                <span x-show="customer.phone" x-text="'Phone: ' + customer.phone"></span>
                                                <span x-show="customer.cnic" x-text="' | CNIC: ' + customer.cnic"></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content: Items & Preview -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Left: Items Selection (2/3) -->
                    <div class="lg:col-span-2 space-y-4">
                        <!-- Counter and Payment Type -->
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Counter</label>
                                    <select name="counter_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">No Counter</option>
                                        @foreach($counters as $counter)
                                            <option value="{{ $counter->id }}">{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Type</label>
                                    <select name="payment_type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="prepaid" {{ $paymentType === 'prepaid' ? 'selected' : '' }}>Prepaid</option>
                                        <option value="postpaid" {{ $paymentType === 'postpaid' ? 'selected' : '' }}>Postpaid</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Barcode Entry -->
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quick Barcode Entry</label>
                            <input type="text" 
                                   x-model="barcodeInput"
                                   @keyup.enter="addByBarcode()"
                                   placeholder="Scan or enter barcode and press Enter"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <!-- Tabs for Products, Services, Service Providers -->
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="border-b border-gray-200">
                                <nav class="flex -mb-px">
                                    <button type="button" 
                                            @click="activeTab = 'products'"
                                            :class="activeTab === 'products' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                            class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm transition">
                                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                        Products
                                    </button>
                                    <button type="button" 
                                            @click="activeTab = 'services'"
                                            :class="activeTab === 'services' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                            class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm transition">
                                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-7 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                        </svg>
                                        Services
                                    </button>
                                    <button type="button" 
                                            @click="activeTab = 'providers'"
                                            :class="activeTab === 'providers' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                            class="flex-1 py-4 px-1 text-center border-b-2 font-medium text-sm transition">
                                        <svg class="w-5 h-5 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Providers
                                    </button>
                                </nav>
                            </div>

                            <div class="p-4">
                                <!-- Products Tab -->
                                <div x-show="activeTab === 'products'" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($products as $product)
                                    <div @click="addItemQuick('product', {{ $product->id }}, '{{ $product->name }}', {{ $product->price }})"
                                         class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition">
                                        <div class="font-medium text-sm text-gray-900">{{ $product->name }}</div>
                                        <div class="text-xs text-gray-600 mt-1">${{ number_format($product->price, 2) }}</div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Services Tab -->
                                <div x-show="activeTab === 'services'" class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($services as $service)
                                    <div @click="addItemQuick('service', {{ $service->id }}, '{{ $service->name }}', {{ $service->price }})"
                                         class="p-3 border-2 border-gray-200 rounded-lg hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition">
                                        <div class="font-medium text-sm text-gray-900">{{ $service->name }}</div>
                                        <div class="text-xs text-gray-600 mt-1">${{ number_format($service->price, 2) }}</div>
                                    </div>
                                    @endforeach
                                </div>

                                <!-- Service Providers Tab -->
                                <div x-show="activeTab === 'providers'" class="space-y-4">
                                    @foreach($serviceProviders as $provider)
                                    <div class="border rounded-lg p-3">
                                        <div class="font-semibold text-gray-900 mb-2">{{ $provider->name }}</div>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                            @foreach($services as $service)
                                            <div @click="addItemQuick('service', {{ $service->id }}, '{{ $service->name }} ({{ $provider->name }})', {{ $service->price }})"
                                                 class="p-2 bg-gray-50 border border-gray-200 rounded hover:border-blue-400 hover:bg-blue-50 cursor-pointer transition text-xs">
                                                {{ $service->name }}
                                                <div class="text-gray-600">${{ number_format($service->price, 2) }}</div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Live Bill Preview (1/3) -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm sticky top-4">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 px-4 py-3 rounded-t-lg">
                                <h3 class="text-lg font-semibold text-white">Bill Preview</h3>
                            </div>
                            <div class="p-4">
                                <!-- Customer Info in Preview -->
                                <div class="mb-4 pb-4 border-b">
                                    <div class="text-xs text-gray-600 mb-1">Customer</div>
                                    <div class="font-medium" x-text="selectedCustomer.name || 'Walk-in'"></div>
                                    <div class="text-xs text-gray-600" x-show="selectedCustomer.phone" x-text="selectedCustomer.phone"></div>
                                </div>

                                <!-- Items List -->
                                <div class="space-y-2 mb-4 max-h-96 overflow-y-auto">
                                    <template x-if="items.length === 0">
                                        <p class="text-sm text-gray-500 italic text-center py-8">No items added</p>
                                    </template>
                                    <template x-for="(item, index) in items" :key="index">
                                        <div class="border-b pb-2">
                                            <input type="hidden" :name="'items[' + index + '][type]'" :value="item.type">
                                            <input type="hidden" :name="'items[' + index + '][id]'" :value="item.id">
                                            <input type="hidden" :name="'items[' + index + '][quantity]'" :value="item.quantity">
                                            <div class="flex justify-between items-start">
                                                <div class="flex-1">
                                                    <div class="text-sm font-medium" x-text="item.name"></div>
                                                    <div class="text-xs text-gray-600">
                                                        <span x-text="item.quantity"></span> × $<span x-text="parseFloat(item.price).toFixed(2)"></span>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="font-medium text-sm">$<span x-text="(item.quantity * item.price).toFixed(2)"></span></div>
                                                    <button type="button" 
                                                            @click="removeItem(index)"
                                                            class="text-xs text-red-600 hover:text-red-800">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <!-- Total -->
                                <div class="border-t pt-4">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span>Total:</span>
                                        <span>$<span x-text="calculateTotal().toFixed(2)"></span></span>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 space-y-2">
                                    <button type="submit" 
                                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-md">
                                        Create Bill
                                    </button>
                                    <a href="{{ route('bills.index') }}" 
                                       class="block w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        function billForm() {
            return {
                activeTab: 'products',
                items: [],
                barcodeInput: '',
                searchQuery: '',
                searchResults: [],
                searchTimeout: null,
                selectedCustomer: {
                    id: null,
                    name: '',
                    gender: '',
                    relation_type: '',
                    relation_name: '',
                    phone: '',
                    cnic: '',
                    date_of_birth: '',
                    age: ''
                },
                
                searchCustomers() {
                    clearTimeout(this.searchTimeout);
                    this.searchQuery = this.selectedCustomer.name;
                    
                    if (this.searchQuery.length < 2) {
                        this.searchResults = [];
                        return;
                    }
                    
                    this.searchTimeout = setTimeout(() => {
                        fetch(`{{ route('customers.search') }}?q=${encodeURIComponent(this.searchQuery)}`)
                            .then(response => response.json())
                            .then(data => {
                                this.searchResults = data;
                            });
                    }, 300);
                },
                
                selectCustomer(customer) {
                    this.selectedCustomer = {
                        id: customer.id,
                        name: customer.name,
                        gender: customer.gender || '',
                        relation_type: customer.relation_type || '',
                        relation_name: customer.relation_name || '',
                        phone: customer.phone || '',
                        cnic: customer.cnic || '',
                        date_of_birth: customer.date_of_birth || '',
                        age: customer.age || ''
                    };
                    this.searchResults = [];
                },
                
                calculateAge() {
                    if (this.selectedCustomer.date_of_birth) {
                        const today = new Date();
                        const birthDate = new Date(this.selectedCustomer.date_of_birth);
                        let age = today.getFullYear() - birthDate.getFullYear();
                        const monthDiff = today.getMonth() - birthDate.getMonth();
                        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                            age--;
                        }
                        this.selectedCustomer.age = age;
                    }
                },
                
                addItemQuick(type, id, name, price) {
                    const existingIndex = this.items.findIndex(item => item.type === type && item.id === id);
                    if (existingIndex > -1) {
                        this.items[existingIndex].quantity++;
                    } else {
                        this.items.push({ type, id, name, price, quantity: 1 });
                    }
                },
                
                addByBarcode() {
                    // Placeholder for barcode functionality
                    // In a real implementation, this would lookup products by barcode
                    if (this.barcodeInput) {
                        alert('Barcode scanning feature - to be implemented with actual barcode mapping');
                        this.barcodeInput = '';
                    }
                },
                
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                
                calculateTotal() {
                    return this.items.reduce((total, item) => {
                        return total + (item.quantity * parseFloat(item.price));
                    }, 0);
                }
            }
        }
    </script>
</x-app-layout>
