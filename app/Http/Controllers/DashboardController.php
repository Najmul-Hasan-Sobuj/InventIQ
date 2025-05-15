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
        try {
            $query = $request->input('query');
            
            if (empty($query)) {
                return redirect()->route('dashboard')
                    ->with('error', 'Query cannot be empty');
            }

            // Get inventory data
            $data = [
                'categories' => Category::with('products')->get(),
                'products' => Product::with('category')->get(),
                'transactions' => InventoryTransaction::with(['product.category'])->get(),
            ];

            // Format data for Gemini
            $context = $this->formatDataForGemini($data);

            // Create the prompt
            $prompt = "Given the following inventory data:\n\n" . $context . "\n\n" . $query;

            // Make the API request using the Gemini package
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                ->generateContent($prompt);

            $generatedText = $result->text();

            // Parse the response to extract structured data
            $structuredData = $this->parseGeminiResponse($generatedText, $data);

            return view('dashboard.query-results', [
                'result' => $generatedText,
                'structuredData' => $structuredData,
                'prompt' => $query
            ]);

        } catch (\Exception $e) {
            return redirect()->route('dashboard')
                ->with('error', 'Error processing your query: ' . $e->getMessage());
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

    private function parseGeminiResponse($response, $data)
    {
        $structuredData = [
            'summary' => $response,
            'categories' => [],
            'products' => [],
            'transactions' => []
        ];

        // Extract category information
        foreach ($data['categories'] as $category) {
            $structuredData['categories'][] = [
                'id' => $category->id,
                'name' => $category->name,
                'product_count' => $category->products->count(),
                'total_stock' => $category->products->sum('quantity')
            ];
        }

        // Extract product information
        foreach ($data['products'] as $product) {
            $structuredData['products'][] = [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'category' => $product->category->name,
                'quantity' => $product->quantity,
                'price' => $product->price
            ];
        }

        // Extract recent transactions
        foreach ($data['transactions']->take(10) as $transaction) {
            $structuredData['transactions'][] = [
                'id' => $transaction->id,
                'type' => $transaction->type,
                'quantity' => $transaction->quantity,
                'product_name' => $transaction->product->name,
                'notes' => $transaction->notes,
                'created_at' => $transaction->created_at->format('Y-m-d H:i:s')
            ];
        }

        return $structuredData;
    }
} 