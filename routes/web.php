<?php

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

Route::redirect('/','/home');

Auth::routes();

/*Rotas Carrinho*/
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/carrinho', 'CarrinhoController@index')->name('carrinho.index')->middleware('auth');
Route::get('/add-to-carrinho/{produto}', 'CarrinhoController@add')->name('carrinho.add')->middleware('auth');
Route::get('/carrinho/destroy/{produto}', 'CarrinhoController@destroy')->name('carrinho.destroy')->middleware('auth');
Route::get('/carrinho/update/{produto}', 'CarrinhoController@update')->name('carrinho.update')->middleware('auth');
Route::get('/carrinho/checkout', 'CarrinhoController@checkout')->name('carrinho.checkout')->middleware('auth');

/*Rotas Pedidos*/
Route::resource('/pedido', 'PedidoController')->middleware('auth');



