@extends('layouts.portal')

@section('title', 'Available Courses')

@section('content')
<section class="hero p-4 p-md-5 mb-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="display-6 fw-bold">Find your next course</h1>
            <p class="lead mb-0">Explore available courses and register online in a few simple steps.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <span class="badge bg-light text-primary fs-6">{{ $courses->count() }} courses available</span>
        </div>
    </div>
</section>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-3">
    <div>
        <h2 class="h3 mb-1">Available courses</h2>
        <p class="text-secondary mb-0">Choose a course and complete the registration form.</p>
    </div>
    <input id="courseSearch" type="search" class="form-control" style="max-width:340px"
           placeholder="Search courses..." aria-label="Search courses">
</div>

<div class="row g-4" id="courseGrid">
    @forelse($courses as $course)
        <div class="col-12 col-md-6 col-lg-4 course-item">
            <div class="card course-card h-100">
                <div class="card-body d-flex flex-column">
                    <span class="badge text-bg-primary align-self-start mb-3">Course</span>
                    <h3 class="h5 course-name">{{ $course->name }}</h3>
                    <p class="text-secondary flex-grow-1">{{ $course->description ?: 'Contact the administrator for course details.' }}</p>
                    <p class="fw-semibold mb-3">Fee: {{ number_format((float) $course->price, 2) }}</p>

                    <form method="POST" action="{{ route('courses.register', $course) }}" class="registration-form">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label required-label">Full name</label>
                            <input name="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                        </div>
                        <div class="mb-2">
                            <label class="form-label required-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email') }}" required maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required-label">Phone</label>
                            <input name="phone" type="tel" class="form-control" value="{{ old('phone') }}" required maxlength="30">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register for this course</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No courses are available at the moment. Please check again later.</div>
        </div>
    @endforelse
</div>
<div id="noResults" class="alert alert-warning mt-3 d-none">No matching courses found.</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('courseSearch');
    const cards = Array.from(document.querySelectorAll('.course-item'));
    const noResults = document.getElementById('noResults');

    search.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const name = card.querySelector('.course-name').textContent.toLowerCase();
            const matches = name.includes(term);
            card.classList.toggle('d-none', !matches);
            if (matches) visible++;
        });

        noResults.classList.toggle('d-none', visible !== 0);
    });
});
</script>
@endpush
