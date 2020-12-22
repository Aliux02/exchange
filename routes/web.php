<?php
use App\Models\Stock;
use App\Http\Controllers\TradeController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=>'stock'], function () {
    Route::get('/', [StockController::class, 'index'])->name('stock.index');   

    Route::get('/sort/{smt}', [StockController::class, 'sort'])->name('stock.sort'); 

    Route::get('/create', [StockController::class, 'create'])->name('stock.create');   

    Route::post('/store', [StockController::class, 'store'])->name('stock.store');   

    Route::get('/edit/{stock}', [StockController::class, 'edit'])->name('stock.edit');

    Route::post('/update/{stock}', [StockController::class, 'update'])->name('stock.update');

    Route::get('/destroy/{stock}', [StockController::class, 'destroy'])->name('stock.destroy');
});

Route::group(['prefix'=>'trade'], function () {
    Route::get('/', [TradeController::class, 'index'])->name('trade.index');   

    Route::get('/create', [TradeController::class, 'create'])->name('trade.create');   

    Route::post('/store', [TradeController::class, 'store'])->name('trade.store');   

    Route::post('/populate', [TradeController::class, 'populateTrades'])->name('trade.populate');

});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
