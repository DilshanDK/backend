<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getDatabaseName();
        return response()->json([
            'status' => 'success',
            'message' => 'Database connection established successfully!',
            'database' => DB::connection()->getDatabaseName(),
            'driver' => config('database.default')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Database connection failed!',
            'error' => $e->getMessage()
        ], 500);
    }
});
