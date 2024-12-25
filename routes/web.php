<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('countries', CountryController::class);
Route::get('fetch-countries', [CountryController::class, 'fetchCountries']);
Route::resource('states', StateController::class);
Route::get('fetch-states/{countryId}', [StateController::class, 'fetchStatesByCountry']);
Route::get('fetch-states', [StateController::class, 'fetchStates']);
Route::resource('cities', CityController::class);
Route::get('fetch-cities', [CityController::class, 'fetchCities']);
