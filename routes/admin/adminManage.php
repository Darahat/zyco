<?php
use App\Http\Controllers\AdminController;

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard'); 
    // manage admin
    Route::get('/addAdminForm', [AdminController::class, 'addAdminForm'])->name('addAdminForm'); 
    Route::post('/addAdmin', [AdminController::class, 'addAdmin'])->name('addAdmin'); 
	Route::get('/editAdminForm/{id}', [AdminController::class,'editAdminForm'])->name('editAdminForm');
    Route::post('/editAdmin/{id}', [AdminController::class,'editAdmin'])->name('editAdmin');
    Route::get('/admin-list', [AdminController::class, 'index'])->name('admin_list'); 
    Route::get('/deleteAdmin/{id}', [AdminController::class, 'deleteAdmin'])->name('deleteAdmin'); 
    Route::get('/getAdminDetails', [AdminController::class, 'getAdminDetails'])->name('getAdminDetails');