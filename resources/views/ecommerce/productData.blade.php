@extends('dashboard')

@section('ecommerce')
    <div class="container mx-auto py-8">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>  
        @endif

        <!-- Product Form -->
        <div class="bg-white p-6 rounded shadow-md mb-6">
            <h2 class="text-2xl font-bold mb-4">Add New Product</h2>
            <form id="product-form" action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-300 rounded"></textarea>
                </div>
                
                <div class="mb-4">
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" id="price" name="price" step="0.01" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Product</button>
            </form>
        </div>

        <!-- Product Table -->
        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-2xl font-bold mb-4">Product List</h2>
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr>
                        <th class="border border-gray-200 p-2">ID</th>
                        <th class="border border-gray-200 p-2">Name</th>
                        <th class="border border-gray-200 p-2">Description</th>
                        <th class="border border-gray-200 p-2">Price</th>
                        <th class="border border-gray-200 p-2">Quantity</th>
                        <th class="border border-gray-200 p-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td class="border border-gray-200 p-2">{{ $product->id }}</td>
                            <td class="border border-gray-200 p-2">{{ $product->name }}</td>
                            <td class="border border-gray-200 p-2">{{ $product->description }}</td>
                            <td class="border border-gray-200 p-2">${{ number_format($product->price, 2) }}</td>
                            <td class="border border-gray-200 p-2">{{ $product->quantity }}</td>
                            <td class="border border-gray-200 p-2">
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
