<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleHasPermissionController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CasillasController;
use App\Http\Controllers\DespachosController;
use App\Http\Controllers\ReclamosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::put('utest/{id}/restoring', [UserController::class, 'restoring'])->name('users.restoring');
    Route::get('users/excel', [UserController::class, 'excel'])->name('users.excel');
    Route::get('users/pdf', [UserController::class, 'pdf'])->name('users.pdf');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/role/create', [RoleController::class, 'create'])->name('roles.create');
    // Route::get('/role/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::post('/role', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/role/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/role/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/role/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    //Permisos
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    // Route::get('/permission/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::post('/permission', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permission/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/permission/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permission/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    //Accesos
    Route::get('/role-has-permissions', [RoleHasPermissionController::class, 'index'])->name('role-has-permissions.index');
    Route::get('/role-has-permission/create', [RoleHasPermissionController::class, 'create'])->name('role-has-permissions.create');
    // Route::get('/role-has-permission/{roleHasPermission}', [RoleHasPermissionController::class, 'show'])->name('role-has-permissions.show');
    Route::post('/role-has-permission', [RoleHasPermissionController::class, 'store'])->name('role-has-permissions.store');
    Route::get('/role-has-permission/{roleHasPermission}/edit', [RoleHasPermissionController::class, 'edit'])->name('role-has-permissions.edit');
    Route::put('/role-has-permission/{roleHasPermission', [RoleHasPermissionController::class, 'update'])->name('role-has-permissions.update');
    Route::delete('/role-has-permission/{roleHasPermission}', [RoleHasPermissionController::class, 'destroy'])->name('role-has-permissions.destroy');

    Route::get('/packages', [PackageController::class, 'getPackages']);
    Route::get('/ventanilla', [PackageController::class, 'getVentanilla']);
    Route::get('/generados', [PackageController::class, 'getGenerados']);
    Route::get('/estadisticaso', [PackageController::class, 'getEstadisticaso']);
    Route::get('/packagesdd', [PackageController::class, 'getPackagesDD']);
    Route::get('/ventanilladd', [PackageController::class, 'getVentanillaDD']);
    Route::get('/generadosdd', [PackageController::class, 'getGeneradosDD']);
    Route::get('/estadisticasodd', [PackageController::class, 'getEstadisticasoDD']);
    Route::get('/packagesdnd', [PackageController::class, 'getPackagesDND']);
    Route::get('/ventanilladnd', [PackageController::class, 'getVentanillaDND']);
    Route::get('/generadosdnd', [PackageController::class, 'getGeneradosDND']);
    Route::get('/estadisticasodnd', [PackageController::class, 'getEstadisticasoDND']);
    Route::get('/packageseca', [PackageController::class, 'getPackagesECA']);
    Route::get('/ventanillaeca', [PackageController::class, 'getVentanillaECA']);
    Route::get('/generadoseca', [PackageController::class, 'getGeneradosECA']);
    Route::get('/estadisticasoeca', [PackageController::class, 'getEstadisticasoECA']);
    Route::get('/packagescasillas', [PackageController::class, 'getPackagesCASILLAS']);
    Route::get('/ventanillacasillas', [PackageController::class, 'getVentanillaCASILLAS']);
    Route::get('/generadoscasillas', [PackageController::class, 'getGeneradosCASILLAS']);
    Route::get('/estadisticasocasillas', [PackageController::class, 'getEstadisticasoCASILLAS']);
    Route::get('/packagesencomiendas', [PackageController::class, 'getPackagesENCOMIENDAS']);
    Route::get('/ventanillaencomiendas', [PackageController::class, 'getVentanillaENCOMIENDAS']);
    Route::get('/generadosencomiendas', [PackageController::class, 'getGeneradosENCOMIENDAS']);
    Route::get('/estadisticasoencomiendas', [PackageController::class, 'getEstadisticasoENCOMIENDAS']);
    Route::get('/estadisticasdespachos', [DespachosController::class, 'getEstadisticasdespachos']);

    Route::get('/apertura', [DespachosController::class, 'getApertura']);
    Route::get('/cerrado', [DespachosController::class, 'getCerrado']);
    Route::get('/expedicion', [DespachosController::class, 'getExpedicion']);
    Route::get('/observado', [DespachosController::class, 'getObservado']);
    Route::get('/admitido', [DespachosController::class, 'getAdmitido']);

    Route::get('/alquiladas', [CasillasController::class, 'getAlquiladas']);
    Route::get('/libres', [CasillasController::class, 'getLibres']);
    Route::get('/mantenimiento', [CasillasController::class, 'getMantenimiento']);
    Route::get('/vencidas', [CasillasController::class, 'getVencidas']);
    Route::get('/correspondencia', [CasillasController::class, 'getCorrespondencia']);
    Route::get('/reservadas', [CasillasController::class, 'getReservadas']);
    Route::get('/estadisticasc', [CasillasController::class, 'getEstadisticasc']);

    Route::get('/estadisticasr', [ReclamosController::class, 'getEstadisticasr']);
    Route::get('/informaciones', [ReclamosController::class, 'getInformaciones']);
    Route::get('/quejas', [ReclamosController::class, 'getQuejas']);
    Route::get('/reclamos', [ReclamosController::class, 'getReclamos']);
    Route::get('/sugerencias', [ReclamosController::class, 'getSugerencias']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
