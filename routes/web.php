<?php

use App\Http\Controllers\AppartsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CelliersController;
use App\Http\Controllers\ChargesController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EchancesController;
use App\Http\Controllers\EcheancesController;
use App\Http\Controllers\EtagesController;
use App\Http\Controllers\ParkingsController;
use App\Http\Controllers\ResidencesController;

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
    Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
    Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store');
    Route::post('/clients/{id}', [ClientsController::class, 'update'])->name('clients.update');
    Route::get('/clients/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy');
    Route::get('/client/{id}', [ClientsController::class, 'get'])->name('clients.get');

    Route::get('/residences', [ResidencesController::class, 'index'])->name('residences');
    Route::post('/residences', [ResidencesController::class, 'store'])->name('residences.store');
    Route::post('/residences/{id}', [ResidencesController::class, 'update'])->name('residences.update');
    Route::get('/residences/{id}', [ResidencesController::class, 'destroy'])->name('residences.destroy');
    Route::get('/residence/{id}', [ResidencesController::class, 'get'])->name('residences.get');
    Route::get('/residencess/{id}', [ResidencesController::class, 'show'])->name('residences.show');

    Route::get('/etages', [EtagesController::class, 'index'])->name('etages');
    Route::post('/etages', [EtagesController::class, 'store'])->name('etages.store');
    Route::post('/etages/{id}', [EtagesController::class, 'update'])->name('etages.update');
    Route::get('/etages/{id}', [EtagesController::class, 'destroy'])->name('etages.destroy');
    Route::get('/etage/{id}', [EtagesController::class, 'get'])->name('etages.get');
    Route::get('/etagess/{id}', [EtagesController::class, 'show'])->name('etages.show');

    Route::get('/apparts', [AppartsController::class, 'index'])->name('apparts');
    Route::post('/apparts', [AppartsController::class, 'store'])->name('apparts.store');
    Route::post('/apparts/{id}', [AppartsController::class, 'update'])->name('apparts.update');
    Route::get('/apparts/{id}', [AppartsController::class, 'destroy'])->name('apparts.destroy');
    Route::get('/appart/{id}', [AppartsController::class, 'get'])->name('apparts.get');
    Route::get('/appartss/{id}', [AppartsController::class, 'show'])->name('apparts.show');

    Route::get('/celliers', [CelliersController::class, 'index'])->name('celliers');
    Route::post('/celliers', [CelliersController::class, 'store'])->name('celliers.store');
    Route::post('/celliers/{id}', [CelliersController::class, 'update'])->name('celliers.update');
    Route::get('/celliers/{id}', [CelliersController::class, 'destroy'])->name('celliers.destroy');
    Route::get('/cellier/{id}', [CelliersController::class, 'get'])->name('celliers.get');

    Route::get('/parkings', [ParkingsController::class, 'index'])->name('parkings');
    Route::post('/parkings', [ParkingsController::class, 'store'])->name('parkings.store');
    Route::post('/parkings/{id}', [ParkingsController::class, 'update'])->name('parkings.update');
    Route::get('/parkings/{id}', [ParkingsController::class, 'destroy'])->name('parkings.destroy');
    Route::get('/parking/{id}', [ParkingsController::class, 'get'])->name('parkings.get');

    Route::get('/charges', [ChargesController::class, 'index'])->name('charges');
    Route::post('/charges', [ChargesController::class, 'store'])->name('charges.store');
    Route::post('/charges/{id}', [ChargesController::class, 'update'])->name('charges.update');
    Route::get('/charges/{id}', [ChargesController::class, 'destroy'])->name('charges.destroy');
    Route::get('/charge/{id}', [ChargesController::class, 'get'])->name('charges.get');

    Route::get('/echanciers', [EchancesController::class, 'index'])->name('echances');
    Route::post('/echanciers', [EchancesController::class, 'store'])->name('echances.store');
    Route::post('/echanciers/{id}', [EchancesController::class, 'update'])->name('echances.update');
    Route::get('/echanciers/{id}', [EchancesController::class, 'destroy'])->name('echances.destroy');
    Route::get('/echancier/{id}', [EchancesController::class, 'get'])->name('echances.get');
    Route::get('/echancierss/{id}', [EchancesController::class, 'show'])->name('echances.show');

    
    Route::get('/echeances',[EcheancesController::class, 'index'])->name('echeances');
    Route::post('/echeances',[EcheancesController::class, 'store'])->name('echeances.store');
    Route::get('/echeances/update/{id}',[EcheancesController::class, 'update'])->name('echeances.update');
    Route::get('/echeances/{id}',[EcheancesController::class, 'destroy'])->name('echeances.destroy');
    Route::get('/echeance/{id}',[EcheancesController::class, 'get'])->name('echeances.get');
});
