<?php
Route::name('bageur.karir.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/karir'], function () {
		Route::apiResource('lowongan', 'Bageur\Karir\Controllers\LowonganController');
		Route::apiResource('perusahaan', 'Bageur\Karir\Controllers\PerusahaanController');
		Route::apiResource('members', 'Bageur\Karir\Controllers\KarirMembersController');
		Route::apiResource('lamaran', 'Bageur\Karir\Controllers\LamaranController');
	});
});
