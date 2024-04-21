<?php

use App\Http\Controllers\AbonnementController;
use App\Http\Controllers\AppartsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CelliersController;
use App\Http\Controllers\ChargesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepensesController;
use App\Http\Controllers\EchancesController;
use App\Http\Controllers\EcheancesController;
use App\Http\Controllers\EtagesController;
use App\Http\Controllers\ParkingsController;
use App\Http\Controllers\ReglementController;
use App\Http\Controllers\ResidencesController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => ['guest']], function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout.perform');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appart/{id}', [AppartsController::class, 'get'])->name('apparts.get');
    
    Route::get('/depenses', [DepensesController::class, 'index'])->name('depenses.index');
    Route::post('/depenses', [DepensesController::class, 'store'])->name('depenses.store');
    Route::get('/depense/{id}', [DepensesController::class, 'get'])->name('depenses.get');
    Route::post('/depenses/{id}', [DepensesController::class, 'update'])->name('depenses.update');
    Route::get('/depenses/{id}', [DepensesController::class, 'destroy'])->name('depenses.destroy');

    Route::get('/abonnements', [AbonnementController::class, 'index'])->name('abonnements.index');
    Route::post('/abonnements', [AbonnementController::class, 'store'])->name('abonnements.store');
    Route::get('/abonnement/{id}', [AbonnementController::class, 'get'])->name('abonnements.get');
    Route::post('/abonnements/{id}', [AbonnementController::class, 'update'])->name('abonnements.update');
    Route::get('/abonnements/{id}', [AbonnementController::class, 'destroy'])->name('abonnements.destroy');

    Route::get('/details_abonnement/{id}', [ReglementController::class, 'index'])->name('reglements.index');
    Route::post('/reglements', [ReglementController::class, 'store'])->name('reglements.store');
    Route::get('/reglement/{id}', [ReglementController::class, 'get'])->name('reglements.get');
    Route::post('/reglements/{id}', [ReglementController::class, 'update'])->name('reglements.update');
    Route::get('/reglements/{id}', [ReglementController::class, 'destroy'])->name('reglements.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
