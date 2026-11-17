<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\View\View;

class AdminRegistrationController extends Controller
{
    public function index(): View
    {
        $registrations = Registration::with('course')->latest()->paginate(15);

        return view('admin.registrations.index', compact('registrations'));
    }
}
