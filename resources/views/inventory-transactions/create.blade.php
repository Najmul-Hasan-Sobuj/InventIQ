@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">New Inventory Transaction</h2>
        </div>

        <form action="{{ route('inventory-transactions.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="mb-4">
                    <label for="product_id" class="block text-sm font-medium text-gray-700">Product</label>
                    <select name="product_id" id="product_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="">Select a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (Current Stock: {{ $product->quantity }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
                    <select name="type" id="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="in">Stock In</option>
                        <option value="out">Stock Out</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Optional notes about this transaction"></textarea>
            </div>

            <div class="flex items-center justify-end">
                <a href="{{ route('inventory-transactions.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-3">
                    Cancel
                </a>
                <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Record Transaction
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 