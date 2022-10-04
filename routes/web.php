<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('admin/mimi', function () {

    $exitCode = Artisan::call('migrate');
    echo $exitCode;
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/invoices/{order_key}/{order_id}', InvoiceController::class)->name('invoices');
Route::get('/transactions/{customer_id}/{public_key}', [TransactionController::class,"customer_portal"])->name('transaction.portal');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class,"index"])->name('dashboard');


    /** Companies Informations */

    Route::middleware(['company.check'])->group(function () {

        Route::put('/customers/{customer_id}/storecomment', [CustomerController::class,"storeComment"])->name('customers.storeComment');

        Route::get('/company/kanban', [CompanyController::class,"kanban"])->name('company.kanban');
        Route::get('/company/settings', [CompanyController::class,"my_company"])->name('company.settings');
        Route::resource('projects', ProjectController::class);
        Route::resource('feedbacks', FeedbackController::class);
        Route::resource('payments', PaymentController::class);

        Route::put('/orders/{order_id}/sendmessage', [OrderController::class,"sendMailtoCustomer"])->name('orders.sendmessage');
        Route::get('/orders/{order_id}/clone', [OrderController::class,"cloneOrder"])->name('orders.clone');
        Route::resource('orders', OrderController::class);

        Route::resource('customers', CustomerController::class);
    });


    Route::resource('companies', CompanyController::class);

    Route::get('admin/link', function () {
        $exitCode = Artisan::call('storage:link');
        echo $exitCode;
    });
});



