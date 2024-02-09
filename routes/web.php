<?php

use App\Http\Controllers\Account\ClientAccountsListController;
use App\Http\Controllers\Account\MovementsController;
use App\Http\Controllers\Client\SaveClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\TransactionsClientsController;
use App\Http\Controllers\Account\SaveAccountController;
use App\Http\Controllers\Account\SaveDepositController;
use App\Http\Controllers\Account\SaveWithdrawalController;
use App\Http\Controllers\Client\ClientListController;
use Illuminate\Foundation\Application;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    /* Clients */
    Route::get('/clients', [ClientListController::class, 'index'])->name('clients.index');
    Route::get('/clients-create', [SaveClientController::class, 'index'])->name('clients.form');
    Route::post('/clients-create', [SaveClientController::class, 'store'])->name('clients.store');

    /* Accounts */
    Route::get('/accounts-list/{client}', [ClientAccountsListController::class, 'index'])->name('accounts.list');

    Route::get('/account-create/{client}', [SaveAccountController::class, 'index'])->name('account.form');
    Route::post('/account-create/{client}', [SaveAccountController::class, 'store'])->name('account.store');

    Route::get('/deposit-create/{account}', [SaveDepositController::class, 'index'])->name('deposit.form');
    Route::post('/deposit-create/{account}', [SaveDepositController::class, 'store'])->name('deposit.store');

    Route::get('/withdrawal-create/{account}', [SaveWithdrawalController::class, 'index'])->name('withdrawal.form');
    Route::post('/withdrawal-create/{account}', [SaveWithdrawalController::class, 'store'])->name('withdrawal.store');

    Route::get('/movements/{account}', [MovementsController::class, 'index'])->name('movements.list');


    Route::get('/transactions-clients', [TransactionsClientsController::class, 'index'])->name('transactions.index');
});

require __DIR__ . '/auth.php';
