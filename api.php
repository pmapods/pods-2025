<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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

// Route::middleware('auth:api')->group(function (Request $request) {
//     return $request->user();
// });
Route::middleware(['simple_token'])->group(function () {
    Route::post('/testapi', [APIController::class,'testAPI']);
    Route::post('/updateassetnumber', [APIController::class,'updateAssetNumber']);
    Route::get('/bidding/{encrypted_bidding_id}/printview',[APIController::class, 'printBidding']);
});
