<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::group(['middleware'=>'auth:sanctum'], function(){


//     Route::get('apiLoans', 'App\Http\Controllers\LoanController@apiLoans');
// });



Route::get('apiLoans', 'App\Http\Controllers\LoanController@apiLoans');
Route::post('appove-loan', 'App\Http\Controllers\LoanController@ApiApproveLoan');
Route::post('login-user', 'App\Http\Controllers\LoanController@ApiLogin');
Route::post('loan-application', 'App\Http\Controllers\LoanController@ApiLoanApply');


