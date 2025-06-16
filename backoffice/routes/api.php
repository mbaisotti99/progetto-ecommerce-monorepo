<?php

use App\Categorie;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(["prefix" => "prods"], function(){
    Route::get("/best", [ApiController::class, "best"]);
    Route::get("/", [ApiController::class, "index"]);
    Route::get("/{id}", [ApiController::class, "show"]);
    Route::get("/cat/{category}", [ApiController::class, "filterCat"]);
    Route::get("/search/{search}", [ApiController::class, "search"]);
});

Route::post("/advancedSearch", [ApiController::class, "advancedSearch"]);

Route::get("/cats", function(){
    $cats = Categorie::cases();

    return response()->json([
        "success" => true,
        "data" => $cats
    ]);
});