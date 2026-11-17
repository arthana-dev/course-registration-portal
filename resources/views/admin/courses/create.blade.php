@extends('layouts.portal')
@section('title', 'Add Course')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="h3 mb-4">Add a course</h1>
                <form method="POST" action="{{ route('admin.courses.store') }}">
                    @csrf

<div class="mb-3">
    <label class="form-label">Course name *</label>
    <input name="name" class="form-control" value="{{ old('name', $course->name ?? '') }}" required maxlength="255">
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4">{{ old('description', $course->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Price *</label>
    <input name="price" type="number" min="0" step="0.01" class="form-control"
           value="{{ old('price', $course->price ?? '0.00') }}" required>
</div>

                    <button class="btn btn-primary">Save course</button>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
