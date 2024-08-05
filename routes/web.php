<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/setup', function () {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'password'
    ];

    if(!Auth::attempt($credentials)) {
        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        
        $user->save();
      

        if(Auth::attempt($credentials)){
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create','update','delete', 'view']);
            $updateToken = $user->createToken('update-token', ['create','update', 'view']);
            $basicToken = $user->createToken('basic-token', ['view']);
            
       

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken,
            ];
        }
    }
});


