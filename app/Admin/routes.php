<?php

Route::get('', ['as' => 'admin.dashboard', function () {
	$content = 'Перейдите в требуемый раздел нажав пункт меню слева';
	return AdminSection::view($content, 'Dashboard');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);