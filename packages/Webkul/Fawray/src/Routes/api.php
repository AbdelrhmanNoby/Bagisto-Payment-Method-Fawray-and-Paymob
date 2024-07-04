<?php 

use Illuminate\Support\Facades\Route;
use Webkul\Fawray\Http\Controllers\ApiFawrayController;

Route::get("api/fawray",[ApiFawrayController::class,"index"]);

Route::post("api/fawray/login",[ApiFawrayController::class,"login"]);






?>


