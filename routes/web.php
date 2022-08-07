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

Route::get('/','DoctorController@getDoctors');
Route::get('/getDoctorsList','DoctorController@getDoctorsList');
Route::get('/getDoctorsDetails','DoctorController@getDoctorsDetails');


Route::get('/DoctorsAvailability','DoctorsAvailabilityController@addDoctorsAvailability')->name('addDoctorsAvailability');
Route::get('/DoctorsAvailability/{id}','DoctorsAvailabilityController@editDoctorsAvailability');
Route::get('/DeleteDoctorsAvailability/{id}','DoctorsAvailabilityController@deleteDoctorsAvailability');
Route::get('/ShowDoctorsAvailability/{id}','DoctorsAvailabilityController@showDoctorsAvailability');

Route::post('/DoctorsAvailability','DoctorsAvailabilityController@saveDoctorsAvailability');
Route::post('/DoctorsAvailability/{id}','DoctorsAvailabilityController@updateDoctorsAvailability');