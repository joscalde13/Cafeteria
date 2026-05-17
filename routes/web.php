<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImpuestoController;
use App\Http\Controllers\ImpuestoMensualController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Rutas protegidas por autenticación
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Rutas accesibles por ADMIN y EMPLOYEE
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin,employee'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('ventas', VentaController::class)->except(['edit', 'update']);
        Route::resource('inventario', InventarioController::class)->only(['index', 'create', 'store']);
    });

    /*
    |----------------------------------------------------------------------
    | Rutas accesibles SOLO por ADMIN
    |----------------------------------------------------------------------
    */
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('categorias', CategoriaController::class);
        Route::resource('productos', ProductoController::class);
        Route::resource('proveedores', ProveedorController::class);
        Route::resource('compras', CompraController::class);
        Route::resource('impuestos', ImpuestoController::class);
        Route::get('impuestos-mensuales', [ImpuestoMensualController::class, 'index'])->name('impuestos-mensuales.index');
        Route::get('impuestos-mensuales/pdf', [ImpuestoMensualController::class, 'pdf'])->name('impuestos-mensuales.pdf');
        Route::resource('usuarios', UsuarioController::class)->except(['show']);
    });
});

require __DIR__ . '/settings.php';
