<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VehicleTypeController;
use App\Http\Controllers\VehicleMakeController;
use App\Http\Controllers\VehicleModelController;
use App\Http\Controllers\VehicleClassificationController;

// Vehicle Type Routes
Route::get('vehicle-type', [VehicleTypeController::class, 'index'])->name('vehicle-type');
Route::match(['GET', 'POST'], 'vehicle-type-form', [VehicleTypeController::class, 'vehicle_type_form'])->name('vehicle-type-form');
Route::match(['GET', 'POST'], 'add-vehicle-type', [VehicleTypeController::class, 'add_vehicle_type'])->name('add-vehicle-type');
Route::get('edit-vehicle-type/{id}', [VehicleTypeController::class, 'edit_form'])->name('edit-vehicle-type');
Route::post('update-vehicle-type', [VehicleTypeController::class, 'update'])->name('update-vehicle-type');
Route::get('delete-vehicle-type/{id}', [VehicleTypeController::class, 'delete_vehicle_type'])->name('delete-vehicle-type');

// Vehicle Make Routes
Route::get('vehicle-make', [VehicleMakeController::class, 'index'])->name('vehicle-make');
Route::match(['GET', 'POST'], 'vehicle-make-form', [VehicleMakeController::class, 'vehicle_make_form'])->name('vehicle-make-form');
Route::match(['GET', 'POST'], 'add-vehicle-make', [VehicleMakeController::class, 'add_vehicle_make'])->name('add-vehicle-make');
Route::get('edit-vehicle-make/{id}', [VehicleMakeController::class, 'edit_form'])->name('edit-vehicle-make');
Route::post('update-vehicle-make', [VehicleMakeController::class, 'update'])->name('update-vehicle-make');
Route::get('delete-vehicle-make/{id}', [VehicleMakeController::class, 'delete_vehicle_make'])->name('delete-vehicle-make');

// Vehicle Model Routes
Route::get('vehicle-model', [VehicleModelController::class, 'index'])->name('vehicle-model');
Route::match(['GET', 'POST'], 'vehicle-model-form', [VehicleModelController::class, 'vehicle_model_form'])->name('vehicle-model-form');
Route::match(['GET', 'POST'], 'add-vehicle-model', [VehicleModelController::class, 'add_vehicle_model'])->name('add-vehicle-model');
Route::get('edit-vehicle-model/{id}', [VehicleModelController::class, 'edit_form'])->name('edit-vehicle-model');
Route::post('update-vehicle-model', [VehicleModelController::class, 'update'])->name('update-vehicle-model');
Route::get('delete-vehicle-model/{id}', [VehicleModelController::class, 'delete_vehicle_model'])->name('delete-vehicle-model');

// Vehicle Classification Routes
Route::get('vehicle-classification', [VehicleClassificationController::class, 'index'])->name('vehicle-classification');
Route::match(['GET', 'POST'], 'add-vehicle-classification', [VehicleClassificationController::class, 'add'])->name('add-vehicle-classification');
Route::get('edit-vehicle-classification/{id}', [VehicleClassificationController::class, 'edit'])->name('edit-vehicle-classification');
Route::post('update-vehicle-classification', [VehicleClassificationController::class, 'update'])->name('update-vehicle-classification');
Route::get('delete-vehicle-classification/{id}', [VehicleClassificationController::class, 'delete'])->name('delete-vehicle-classification');

// Vehicle Management Routes
Route::get('vehicles', [VehicleController::class, 'index'])->name('vehicles');
Route::match(['GET', 'POST'], 'add-vehicle', [VehicleController::class, 'add'])->name('add-vehicle');
Route::get('edit-vehicle/{id}', [VehicleController::class, 'edit'])->name('edit-vehicle');
Route::post('update-vehicle', [VehicleController::class, 'update'])->name('update-vehicle');
Route::get('delete-vehicle/{id}', [VehicleController::class, 'delete'])->name('delete-vehicle');