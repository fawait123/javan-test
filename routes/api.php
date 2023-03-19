<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FamilyController;

Route::get('/family/child/budi',[FamilyController::class,'child']);
Route::get('/family/grandchild/budi',[FamilyController::class,'grandchild']);
Route::get('/family/cousin/hani',[FamilyController::class,'cousin']);
Route::get('/family',[FamilyController::class,'families']);
