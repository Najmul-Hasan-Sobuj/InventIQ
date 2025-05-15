<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Gemini\Laravel\Facades\Gemini;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function listModels()
    {
        try {
            $models = Gemini::models()->list();
            return response()->json([
                'success' => true,
                'models' => $models->models
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Error listing models: ' . $e->getMessage()
            ], 500);
        }
    }

    public function query(Request $request)
    {
        Log::info('Query endpoint hit', ['request' => $request->all()]);
        
        try {
            $query = $request->input('query');
            
            if (empty($query)) {
                Log::warning('Empty query received');
                return response()->json([
                    'success' => false,
                    'error' => 'Query cannot be empty'
                ], 400);
            }

            Log::info('Processing query', ['query' => $query]);
            
            // Get inventory data
            $data = [
                'categories' => Category::with('products')->get(),
                'products' => Product::with('category')->get(),
                'transactions' => InventoryTransaction::with(['product.category'])->get(),
            ];

            Log::info('Retrieved inventory data', [
                'categories_count' => $data['categories']->count(),
                'products_count' => $data['products']->count(),
                'transactions_count' => $data['transactions']->count()
            ]);

            // Format data for Gemini
            $context = $this->formatDataForGemini($data);

            // Create the prompt
            $prompt = "Given the following inventory data:\n\n" . $context . "\n\n" . $query;

            Log::info('Sending prompt to Gemini', ['prompt' => $prompt]);

            // Make the API request using the Gemini package
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                ->generateContent($prompt);

            $generatedText = $result->text();

            Log::info('Received response from Gemini', ['response' => $generatedText]);

            return response()->json([
                'success' => true,
                'result' => $generatedText
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing query', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Error processing your query: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatDataForGemini($data)
    {
        $formatted = "Categories:\n";
        foreach ($data['categories'] as $category) {
            $formatted .= "- {$category->name} (" . $category->products->count() . " products)\n";
        }

        $formatted .= "\nProducts:\n";
        foreach ($data['products'] as $product) {
            $formatted .= "- {$product->name} (Category: {$product->category->name}, Stock: {$product->quantity})\n";
        }

        $formatted .= "\nRecent Transactions:\n";
        foreach ($data['transactions'] as $transaction) {
            $formatted .= "- {$transaction->type}: {$transaction->quantity} units of {$transaction->product->name}\n";
        }

        return $formatted;
    }
} 