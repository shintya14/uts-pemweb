<?php

Route::get('/','FrontendFakultas@home')->name('Fakultas.index');
Route::get('/fakultas','FrontendFakultas@index')->name('Fakultas.fakultas');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // FAKULTAS
    Route::delete('fakultasdatas/destroy', 'FakultasdataController@massDestroy')->name('fakultasdatas.massDestroy');
    Route::post('fakultasdatas/media', 'FakultasdataController@storeMedia')->name('fakultasdatas.storeMedia');
    Route::post('fakultasdatas/ckmedia', 'FakultasdataController@storeCKEditorImages')->name('fakultasdatas.storeCKEditorImages');
    Route::resource('fakultasdatas', 'FakultasdataController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
