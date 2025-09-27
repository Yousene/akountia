<?php
//Route::resource('/quicky', 'EasyCollab\Quicky\QuickyController');
use Illuminate\Support\Facades\Route;

Route::any('/quicky', 'EasyCollab\Quicky\QuickyController@index')->name('quicky');
Route::any('/check-project/{projectName}', 'EasyCollab\Quicky\QuickyController@checkProject')->name('check.project');
