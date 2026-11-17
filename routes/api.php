<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::get('/courses', function () {
    return response()->json(
        Course::query()
            ->select(['id', 'name', 'description', 'price', 'created_at'])
            ->orderBy('name')
            ->get(),
        200
    );
});
