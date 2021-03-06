<?php

use App\Models\ProductCameOut;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCameOutController;
use App\Http\Controllers\RequestProductController;
use App\Http\Controllers\IncomingProductController;

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

Route::get('/login', function(){
    if (\Auth::check()) {
        return redirect('/');
    }
    return view('Auth/login');
} )->name('login');

Route::post('/login', [AuthController::class, 'login'] )->name('login.post');


Route::group(['middleware' => ['auth', 'user_status']], function(){
    
    Route::get('/logout', function(){
        \Auth::logout();
        return redirect('/');
    })->name('logout');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::prefix('/product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product');
        Route::get('/all', [ProductController::class, 'getProducts'])->name('product.all');
        Route::middleware(['admin'])->group(function () { 
            // Route::get('/create', [ProductController::class, 'create'])->name('product.create');
            Route::post('/create', [ProductController::class, 'post'])->name('product.post');
            // Route::get('{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
            Route::put('{id}/edit', [ProductController::class, 'put'])->name('product.put');
            Route::delete('{id}/delete', [ProductController::class, 'delete'])->name('product.delete');
        });
        
    });
    
    Route::middleware(['admin'])->group(function () { 
        Route::prefix('/user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/create', [UserController::class, 'create'])->name('user.create');
            Route::post('/create', [UserController::class, 'post'])->name('user.post');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
            Route::put('{id}/edit', [UserController::class, 'put'])->name('user.put');
            Route::put('{id}/change-password', [UserController::class, 'changePassword'])->name('user.change-password');
            
            Route::delete('/{id}/delete', [UserController::class, 'delete'])->name('user.delete');
            Route::put('/{id}/access', [UserController::class, 'access'])->name('user.access');
        });
    });
    Route::middleware(['admin'])->group(function () { 
        Route::prefix('/incoming-product')->group(function () {
            Route::get('/', [IncomingProductController::class, 'index'])->name('incoming-product');
            Route::get('/all', [IncomingProductController::class, 'all'])->name('incoming-product.all');
            // Route::get('/create', [IncomingProductController::class, 'create'])->name('incoming-product.create');
            Route::post('/create', [IncomingProductController::class, 'post'])->name('incoming-product.post');
            // Route::get('/{id}/edit', [IncomingProductController::class, 'edit'])->name('incoming-product.edit');
            Route::put('/{id}/edit', [IncomingProductController::class, 'put'])->name('incoming-product.put');
            Route::delete('/{id}/delete', [IncomingProductController::class, 'delete'])->name('incoming-product.delete');
        });
    });
    
    Route::middleware(['admin'])->group(function () { 
        Route::prefix('/product-came-out')->group(function () {
            Route::get('/', [ProductCameOutController::class, 'index'])->name('product-came-out');
            Route::get('/all', [ProductCameOutController::class, 'all'])->name('product-came-out.all');
            Route::put('/{id}/aproved', [ProductCameOutController::class, 'aproved'])->name('incoming-product.aproved');
            Route::put('/{id}/rejected', [ProductCameOutController::class, 'rejected'])->name('incoming-product.rejected');
        });
    });
    
    Route::prefix('/request-product')->group(function () {
        Route::get('/', [RequestProductController::class, 'index'])->name('request-product');
        Route::get('/all', [RequestProductController::class, 'all'])->name('request-product.all');
        Route::post('/create', [RequestProductController::class, 'post'])->name('request-product.post');
    });
    
    Route::middleware(['admin'])->group(function () { 
        Route::prefix('/report')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('report');
            // Route::get('/search?start={start}&end={end}&status={status}', [ReportController::class, 'search'])->name('report.search');
            Route::get('/search', [ReportController::class, 'search'])->name('report.search');
            Route::post('/pdf', [ReportController::class, 'pdf'])->name('report.pdf');
            Route::get('/pdf', function(){
                $data['reports'] = ProductCameOut::with('product')->get();
                
                return view('report.pdf', $data);
            });
        });
    });
});