<?php


use Illuminate\Support\Facades\Route;

/**
 * Import the components from app/Livewire/*.php
 * then use them in the routes.web.php file !
 */

// Import the HomePage
use App\Livewire\HomePage;

// Import the CategoriesPage
use App\Livewire\CategoriesPage;

// Import the ProductsPage
use App\Livewire\ProductsPage;

// Import the CartPage
use App\Livewire\CartPage;

// Import the ProductDetailPage
use App\Livewire\ProductDetailPage;

// Import the CheckoutPage
use App\Livewire\CheckoutPage;

// Import the MyOrdersPage
use App\Livewire\MyOrdersPage;

// Import the MyOrderDetailsPage
use App\Livewire\MyOrderDetailsPage;

// Import auth pages
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\ForgotPage;

// Import the success and canceled payment pages
use App\Livewire\CancelPage;
use App\Livewire\SuccessPage;

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


// home page route
Route::get('/', HomePage::class);

// if some buttons route to /home redirect to /
Route::redirect('/home', '/');

// categories pages route
Route::get('/categories', CategoriesPage::class);

// cart pages routes
Route::get('/cart', CartPage::class);

// products pages route
Route::get('/products', ProductsPage::class);
Route::get('/products/{slug}', ProductDetailPage::class); // {slug} is to pass the slug from the URL to the component under the hood of Livewire, before rendering the component itself taking the slug from the URL in ProductDetailPage.php

// orders pages routes
Route::get('/my-orders', MyOrdersPage::class);

// only guests can access this routes
Route::middleware('guest')->group(function () {
    // auth routes
    Route::get('/login', Login::class)->name('login'); // name('login') to it when the user is restricted to access the page (checkout page), it will redirect him to the login page by default (this is a Laravel feature)
    Route::get('/register', Register::class);
    Route::get('/reset-password/{token}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/forgot-password', ForgotPage::class)->name('password.request');
});

// only authenticated users can access this routes
Route::middleware('auth')->group(function () {
    // logout route
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    });

    // my order details route
    Route::get('/orders/{orderId}', MyOrderDetailsPage::class)->name('my-orders.show'); // (show the order details)

    // my orders route
    Route::get('/orders', MyOrdersPage::class);

    // checkout route
    Route::get('/checkout', CheckoutPage::class);

    // success and failed payment routes
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
});
