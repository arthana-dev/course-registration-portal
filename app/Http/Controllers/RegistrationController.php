<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('registrations', 'email')
                    ->where(fn ($query) => $query->where('course_id', $course->id)),
            ],
            'phone' => ['required', 'string', 'max:30'],
        ], [
            'email.unique' => 'This email is already registered for this course.',
        ]);

        $course->registrations()->create($validated);

        return redirect()->route('home')
            ->with('success', 'Your registration was submitted successfully.');
    }
}
