<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
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
                
                        <!-- Product Form with dark background -->
                        <div class="bg-gray-800 p-6 rounded shadow-md mb-6">
                            <h2 class="text-2xl font-bold mb-4 text-white">Add New Product</h2>
                            <form id="product-form">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-300">Product Name</label>
                                    <input type="text" id="name" name="name" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" style="background-color: gray;" required>
                                    <span id="name-error" class="text-red-500 text-sm"></span>
                                </div>
                                  
                                <div class="mb-4">
                                    <label for="description" class="block text-sm font-medium text-gray-300">Description</label>
                                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" style="background-color: gray;"></textarea>
                                </div>
                                  
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-300">Price</label>
                                    <input type="number" id="price" name="price" step="0.01" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" style="background-color: gray;" required>
                                    <span id="price-error" class="text-red-500 text-sm"></span>
                                </div>
                                  
                                <div class="mb-4">
                                    <label for="quantity" class="block text-sm font-medium text-gray-300">Quantity</label>
                                    <input type="number" id="quantity" name="quantity" class="mt-1 block w-full p-2 border border-gray-600 rounded bg-gray-700 text-white focus:ring-2 focus:ring-blue-500" style="background-color: gray;" required>
                                    <span id="quantity-error" class="text-red-500 text-sm"></span>
                                </div>
                                  
                                <button type="button" id="add-product-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500" style="background-color: cornflowerblue;">Add Product</button>
                            </form>
                        </div>
                
                        <!-- Product Table with dark background -->
                        <div class="bg-gray-800 p-6 rounded shadow-md">
                            <h2 class="text-2xl font-bold mb-4 text-white">Product List</h2>
                            <table id="product-table" class="w-full border-collapse border border-gray-200">
                                <thead>
                                    <tr class="bg-gray-700 text-white">
                                        <th class="border border-gray-200 p-2">ID</th>
                                        <th class="border border-gray-200 p-2">Name</th>
                                        <th class="border border-gray-200 p-2">Description</th>
                                        <th class="border border-gray-200 p-2">Price</th>
                                        <th class="border border-gray-200 p-2">Quantity</th>
                                        <th class="border border-gray-200 p-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-white">
                                    <!-- Products will be dynamically inserted here -->
                                </tbody>
                            </table>
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

// Function to fetch all products (with authentication token)
const fetchProducts = async () => {
    const token = getApiToken();
    const response = await fetch('/api/products', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,
            'X-CSRF-TOKEN': csrfToken
        }
    });

    const contentType = response.headers.get('Content-Type');
    
    // Check if the response is JSON
    if (contentType && contentType.includes('application/json')) {
        const products = await response.json();
        const tbody = document.querySelector('#product-table tbody');
        tbody.innerHTML = '';

        if (products.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center">No products found.</td></tr>';
            return;
        }

        products.forEach(product => {
            const tr = document.createElement('tr');
            const price = parseFloat(product.price).toFixed(2); 
            tr.innerHTML = `
                <td class="border border-gray-200 p-2">${product.id}</td>
                <td class="border border-gray-200 p-2">${product.name}</td>
                <td class="border border-gray-200 p-2">${product.description}</td>
                <td class="border border-gray-200 p-2">$${price}</td>
                <td class="border border-gray-200 p-2">${product.quantity}</td>
                <td class="border border-gray-200 p-2">
                    <button class="bg-red-500 text-white px-4 py-2 rounded delete-btn" data-id="${product.id}">Delete</button>
                    <a href="/editProduct/${product.id}" class="bg-yellow-500 text-white px-4 py-2 rounded ml-2" style="background-color: cornflowerblue;">Edit</a>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } else {
        const errorText = await response.text();
        console.error('Error: Expected JSON, but received HTML:', errorText);
        alert('Something went wrong! Please check the network tab for more details.');
    }
};


// Function to delete a product (with authentication token)
const deleteProduct = async (id) => {
    const token = getApiToken(); // Get the API token from localStorage
    const response = await fetch(`/api/products/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,  // Send the API token in the request
            'X-CSRF-TOKEN': csrfToken // Send CSRF token as well
        }
    });

    if (response.ok) {
        fetchProducts(); // Refresh the product list
    }
};

// Event listener for delete buttons
document.querySelector('#product-table').addEventListener('click', (e) => {
    if (e.target.classList.contains('delete-btn')) {
        const id = e.target.getAttribute('data-id');
        if (confirm('Are you sure?')) {
            deleteProduct(id);
        }
    }
});

// Event listener for the Add Product button
document.getElementById('add-product-btn').addEventListener('click', async () => {
    const name = document.getElementById('name').value;
    const description = document.getElementById('description').value;
    const price = document.getElementById('price').value;
    const quantity = document.getElementById('quantity').value;

    const token = getApiToken(); // Get the API token from localStorage
    const response = await fetch('/api/products', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`,  // Send the API token in the request
            'X-CSRF-TOKEN': csrfToken // Send CSRF token as well
        },
        body: JSON.stringify({ name, description, price, quantity })
    });

    const data = await response.json();

    if (response.ok) {
        fetchProducts(); // Refresh the product list
        document.getElementById('product-form').reset();
    } else {
        // Handle validation errors
        document.getElementById('name-error').textContent = data.errors?.name || '';
        document.getElementById('price-error').textContent = data.errors?.price || '';
        document.getElementById('quantity-error').textContent = data.errors?.quantity || '';
    }
});

// Fetch products on page load
window.onload = fetchProducts;

    </script>
</x-app-layout>
