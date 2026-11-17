@extends('layouts.portal')
@section('title', 'Registrations')
@section('content')
<h1 class="h3 mb-4">Student registrations</h1>
<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Student</th><th>Email</th><th>Phone</th><th>Course</th><th>Date</th></tr>
            </thead>
            <tbody>
            @forelse($registrations as $registration)
                <tr>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->email }}</td>
                    <td>{{ $registration->phone }}</td>
                    <td>{{ $registration->course?->name ?? 'Course removed' }}</td>
                    <td>{{ $registration->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4">No registrations yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $registrations->links() }}</div>
@endsection
