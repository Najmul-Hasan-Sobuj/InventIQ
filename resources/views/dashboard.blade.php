@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Inventory Dashboard</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Ask About Your Inventory</h2>
            <form id="queryForm" action="{{ route('dashboard.query') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div>
                    <label for="query" class="block text-sm font-medium text-gray-700 mb-2">Enter your question</label>
                    <textarea
                        id="query"
                        name="query"
                        rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Example: What's the current stock level of all products?"></textarea>
                </div>
                <div>
                    <button
                        type="submit"
                        id="submitButton"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Submit Query
                    </button>
                </div>
            </form>
        </div>

        <div id="resultContainer" class="bg-white rounded-lg shadow-md p-6 hidden">
            <h2 class="text-xl font-semibold mb-4">Result</h2>
            <div id="result" class="prose max-w-none"></div>
        </div>

        <div id="errorContainer" class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4 hidden">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800" id="errorTitle">Error</h3>
                    <div class="mt-2 text-sm text-red-700" id="errorMessage"></div>
                </div>
            </div>
        </div>

        <!-- Debug Information -->
        <div class="mt-8 p-4 bg-gray-100 rounded-lg">
            <h3 class="text-lg font-semibold mb-2">Debug Information</h3>
            <div id="debugInfo" class="text-sm font-mono"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('queryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const query = document.getElementById('query').value;
    const resultContainer = document.getElementById('resultContainer');
    const result = document.getElementById('result');
    const errorContainer = document.getElementById('errorContainer');
    const errorMessage = document.getElementById('errorMessage');
    const submitButton = document.getElementById('submitButton');
    const debugInfo = document.getElementById('debugInfo');
    
    // Hide previous results/errors
    resultContainer.classList.add('hidden');
    errorContainer.classList.add('hidden');
    
    // Disable submit button and show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = 'Processing...';
    
    // Clear debug info
    debugInfo.innerHTML = '';
    
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        debugInfo.innerHTML += `CSRF Token: ${csrfToken}\n`;
        
        console.log('Sending query:', query);
        debugInfo.innerHTML += `Sending query: ${query}\n`;
        
        const response = await fetch('{{ route('dashboard.query') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ query })
        });
        
        console.log('Response status:', response.status);
        debugInfo.innerHTML += `Response status: ${response.status}\n`;
        
        const data = await response.json();
        console.log('Response data:', data);
        debugInfo.innerHTML += `Response data: ${JSON.stringify(data, null, 2)}\n`;
        
        if (data.success) {
            result.innerHTML = data.result;
            resultContainer.classList.remove('hidden');
        } else {
            errorMessage.textContent = data.error || 'An error occurred while processing your request.';
            errorContainer.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Error:', error);
        debugInfo.innerHTML += `Error: ${error.message}\n`;
        errorMessage.textContent = 'An error occurred while processing your request: ' + error.message;
        errorContainer.classList.remove('hidden');
    } finally {
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.innerHTML = 'Submit Query';
    }
});
</script>
@endpush
@endsection 