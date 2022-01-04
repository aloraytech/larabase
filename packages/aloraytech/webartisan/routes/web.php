<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Aloraytech\Webartisan\Controller\WebArtisan;

Route::get('/web-artisan', [WebArtisan::class,'index'])->name('web.artisan.help');

Route::get('/web-artisan/clear/{command}', [WebArtisan::class,'clear'])->name('web.artisan.clear');
Route::get('/web-artisan/make/{command}/{subject}', [WebArtisan::class,'make'])->name('web.artisan.make');
Route::get('/web-artisan/optimize', [WebArtisan::class,'optimize'])->name('web.artisan.optimize');
Route::get('/web-artisan/composer/{command?}', [WebArtisan::class,'composer'])->name('web.artisan.composer');
