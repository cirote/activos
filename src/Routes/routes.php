<?php

Route::get('/home', 'Cirote\Activos\Controllers\HomeController@prueba')->name('home');

Route::middleware(['web'])->namespace('Cirote\Activos\Controllers')
	->prefix('brokers')
	->name('brokers.')
	->group(function() 
	{
		Route::get('/', 'BrokersController@index')->name('index');
	});
