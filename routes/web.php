<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InventoryTransactionController;
use App\Http\Controllers\DashboardController;
use Gemini\Laravel\Facades\Gemini;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/dashboard/query', [DashboardController::class, 'query'])->name('dashboard.query');
Route::get('/models', [DashboardController::class, 'listModels'])->name('models');
Route::get('/test-gemini', function () {
    try {
        $response = Gemini::generativeModel(model: 'gemini-2.0-flash')
            ->generateContent('Hello, are you working?');
        return response()->json([
            'success' => true,
            'message' => 'Gemini API is working!',
            'response' => $response->text()
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('/test-query', function () {
    return response()->json([
        'message' => 'Query endpoint is accessible',
        'routes' => collect(Route::getRoutes())->map(function ($route) {
            return [
                'uri' => $route->uri(),
                'methods' => $route->methods(),
                'name' => $route->getName(),
            ];
        })->values()
    ]);
});

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('inventory-transactions', InventoryTransactionController::class);
