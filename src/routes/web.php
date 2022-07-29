<?php

use App\Http\Controllers\LeadController;
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

Route::get('/', fn() => view('index'))->name('index');

Route::post('leads', [LeadController::class, 'store'])
    ->name('leads.create')
    ->middleware('customer');

require __DIR__ . '/auth.php';
