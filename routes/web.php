<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductoProveedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmpleadoController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::resource('proveedor', ProveedorController::class);
Route::resource('categoria', CategoriaController::class);
Route::resource('producto', ProductoController::class);
Route::resource('producto_proveedor', ProductoProveedorController::class);
Route::resource('cliente', ClienteController::class);
Route::resource('venta', VentaController::class);

Route::resource('carrito', CarritoController::class);

Route::get('/factura', [VentaController::class, 'factura'])->name('factura');
Route::get('pdf/{id}', [PDFController::class, 'show'])->name('pdf.show');
Route::delete('devolucion/{id}', [CarritoController::class, 'devolucion'])->name('carrito.devolucion');


Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');});

Route::resource('rol', RolController::class);

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::resource('empleado', EmpleadoController::class);

Route::get('filtrarProductoProCategoria', [ProductoProveedorController::class, 'filtrarProductoProCategoria'])->name('producto_proveedor.filtrarProductoProCategoria');
Route::get('activas', [CategoriaController::class, 'activas'])->name('categoria.activas');
Route::get('inactivas',[CategoriaController::class, 'inactivas'])->name('categoria.inactivas');
Route::get('activos',[ProveedorController::class, 'activos'])->name('proveedor.activos');
Route::get('inactivos',[ProveedorController::class, 'inactivos'])->name('proveedor.inactivos');
Route::get('clienteActivo',[ClienteController::class, 'clienteActivo'])->name('cliente.activos');
Route::get('clienteInactivo',[ClienteController::class, 'clienteInactivo'])->name('cliente.inactivos');
Route::get('productoActivo',[ProductoController::class, 'productoActivo'])->name('producto.activos');
Route::get('productoInactivo',[ProductoController::class, 'productoInactivo'])->name('producto.inactivos');
Route::get('/reportes', [VentaController::class, 'reportes'])->name('venta.reportes');
Route::post('ventaPorDia', [VentaController::class, 'ventaPorDia'])->name('venta.ventaPorDia');