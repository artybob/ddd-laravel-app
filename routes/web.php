<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/slow-query', function () {
    $start = microtime(true);
    $total = DB::table('test_orders')
        ->where('status', 'paid')
        ->sum('total');
    $time = round((microtime(true) - $start) * 1000, 2);

    return response()->json([
        'total' => $total,
        'time_ms' => $time,
        'index_used' => false,
    ]);
});
