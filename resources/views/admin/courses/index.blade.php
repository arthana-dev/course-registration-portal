@extends('layouts.portal')
@section('title', 'Manage Courses')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Manage courses</h1>
        <p class="text-secondary mb-0">Create, edit and remove course listings.</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Add course</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Course</th><th>Fee</th><th>Created</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>
                        <strong>{{ $course->name }}</strong>
                        <div class="small text-secondary">{{ \Illuminate\Support\Str::limit($course->description, 75) }}</div>
                    </td>
                    <td>{{ number_format((float) $course->price, 2) }}</td>
                    <td>{{ $course->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" class="d-inline"
                              onsubmit="return confirm('Delete this course and its registrations?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center py-4">No courses found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $courses->links() }}</div>
@endsection
