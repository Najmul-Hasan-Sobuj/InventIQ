@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8 bg-white rounded-lg shadow-md p-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Query Results</h1>
                    <p class="mt-2 text-sm text-gray-600">Analysis of your inventory data</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('dashboard', ['query' => $prompt]) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200 ease-in-out transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Rewrite Query
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 transition-colors duration-200 ease-in-out transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Prompt Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900">Your Query</h2>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700">{{ $prompt }}</p>
                </div>
            </div>

            <!-- Results Section -->
            @if(isset($result) && !empty($result))
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center mb-6">
                    <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900">Query Response</h2>
                </div>

                <div class="bg-gradient-to-br from-white to-gray-50 rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="prose max-w-none">
                        {!! $result !!}
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Results Found</h3>
                <p class="text-gray-500">Try asking a different question about your inventory.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 