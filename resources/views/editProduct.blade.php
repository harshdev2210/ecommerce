<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="container mx-auto py-8">

                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="bg-green-500 text-white p-4 rounded mb-4">
                                {{ session('success') }}
                            </div>  
                        @endif

                        <div class="bg-gray-800 p-6 rounded shadow-md mb-6">
                            <h2 class="text-2xl font-bold mb-4 text-white">Edit Product</h2>
                            <form id="edit-product-form">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-300">Product Name</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white" value="{{ $product->name }}" style="background-color: gray;"  required>
                                    <span id="name-error" class="text-red-500 text-sm"></span>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white" style="background-color: gray;" >{{ $product->description }}</textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-300">Price</label>
                                    <input type="number" id="price" name="price" step="0.01" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white" style="background-color: gray;" value="{{ $product->price }}" required>
                                    <span id="price-error" class="text-red-500 text-sm"></span>
                                </div>

                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-300">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white" style="background-color: gray;" value="{{ $product->quantity }}" required>
                                    <span id="quantity-error" class="text-red-500 text-sm"></span>
                                </div>

                                <button type="button" id="update-product-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" style="background-color: cornflowerblue;">Update Product</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get CSRF token from meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Helper function to get the API token from localStorage
        const getApiToken = () => localStorage.getItem('api_token');

        // Function to update product details (with authentication token)
        const updateProduct = async (id) => {
            const name = document.getElementById('name').value;
            const description = document.getElementById('description').value;
            const price = document.getElementById('price').value;
            const quantity = document.getElementById('quantity').value;

            const token = getApiToken();
            const response = await fetch(`/api/products/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`,
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ name, description, price, quantity })
            });

            const data = await response.json();

            if (response.ok) {
                alert('Product updated successfully');
                window.location.href = '/dashboard';  // Redirect to dashboard or product list
            } else {
                // Handle validation errors
                document.getElementById('name-error').textContent = data.errors?.name || '';
                document.getElementById('price-error').textContent = data.errors?.price || '';
                document.getElementById('quantity-error').textContent = data.errors?.quantity || '';
            }
        };

        // Event listener for update button
        document.getElementById('update-product-btn').addEventListener('click', async () => {
            const id = window.location.pathname.split('/').pop();  // Get the product ID from URL
            updateProduct(id);
        });
    </script>

</x-app-layout>
