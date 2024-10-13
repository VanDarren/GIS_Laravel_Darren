<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',  [Controller::class, 'dashboard']);
Route::get('/alumni',  [Controller::class, 'alumni']);
Route::get('/addalumni', [Controller::class, 'addalumni']);
Route::get('/user',  [Controller::class, 'user']);
Route::get('/adduser', [Controller::class, 'addUser']);
Route::post('/aksiadduser', [Controller::class, 'aksiAddUser']);
Route::get('/login', [Controller::class, 'login'])->name('login');

Route::post('/aksi_login', [Controller::class, 'aksi_login']);
Route::get('/generate-captcha', [Controller::class, 'generateCaptcha']);
Route::get('/edituser/{id_user}', [Controller::class, 'editUser'])->name('edituser');
Route::put('/updateuser/{id_user}', [Controller::class, 'updateUser'])->name('updateuser');
Route::get('/deleteuser/{id_user}', [Controller::class, 'deleteUser'])->name('deleteuser');

Route::get('/log',  [Controller::class, 'log']);
Route::post('/aksiaddalumni', [Controller::class, 'aksiAddAlumni']);
Route::get('/setting', [Controller::class, 'setting'])->name('setting');
Route::post('/editsetting', [Controller::class, 'editsetting'])->name('setting.edit');
Route::get('/alumnidata', [Controller::class, 'alumnidata'])->name('alumnidata');

Route::get('/error404', [Controller::class, 'error404'])->name('error404');
Route::get('/logout', [Controller::class, 'logout']);

