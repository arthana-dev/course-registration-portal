@extends('layouts.portal')

@section('title', 'Available Courses')

@section('content')
<section class="portal-hero" aria-labelledby="heroTitle">
    <div class="portal-hero-grid" aria-hidden="true"></div>
    <div class="portal-hero-content">
        <span class="portal-eyebrow"><span></span> COURSE REGISTRATION</span>
        <h1 id="heroTitle">Find Your<br><span>Next Course</span></h1>
        <p>Build practical skills with focused courses designed to move you forward.</p>
    </div>
    <div class="portal-availability" aria-label="{{ $courses->count() }} courses available">
        <span class="portal-availability-label">CURRENTLY OPEN</span>
        <strong>{{ str_pad((string) $courses->count(), 2, '0', STR_PAD_LEFT) }}</strong>
        <span>{{ $courses->count() === 1 ? 'course available' : 'courses available' }}</span>
        <span class="portal-availability-rule"></span>
        <small>Choose a course and register online.</small>
    </div>
</section>

<section class="portal-courses" aria-labelledby="coursesHeading">
    <div class="portal-courses-heading">
        <div>
            <span class="portal-section-kicker">YOUR NEXT STEP STARTS HERE</span>
            <h2 id="coursesHeading">Available Courses</h2>
            <p>Explore the programs and find the right fit for you.</p>
        </div>
        <label class="portal-search">
            <span class="portal-search-icon" aria-hidden="true"></span>
            <input id="courseSearch" type="search" placeholder="Search courses" aria-label="Search courses">
            <kbd>/</kbd>
        </label>
    </div>

    <p class="portal-results" aria-live="polite">Showing <span id="visibleCourseCount">{{ $courses->count() }}</span> of {{ $courses->count() }} courses</p>

    <div class="portal-course-grid" id="courseGrid">
    @forelse($courses as $course)
        <article class="portal-course-card course-item" data-course-search="{{ strtolower($course->name.' '.$course->description.' '.$course->price) }}">
            <div class="portal-course-topline">
                <span class="portal-course-tag">PROGRAM <span>{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span></span>
                <span class="portal-course-dot" aria-hidden="true"></span>
            </div>
            <h3 class="course-name">{{ $course->name }}</h3>
            <p class="portal-course-description">{{ $course->description ?: 'Contact the administrator for course details.' }}</p>

            <div class="portal-course-fee">
                <span>Course fee</span>
                <strong>{{ number_format((float) $course->price, 2) }}</strong>
            </div>

            <form method="POST" action="{{ route('courses.register', $course) }}" class="portal-registration-form">
                @csrf
                <div class="portal-field">
                    <label for="student-name-{{ $course->id }}">Full name</label>
                    <input id="student-name-{{ $course->id }}" name="name" value="{{ old('name') }}" required maxlength="255" autocomplete="name" placeholder="Your full name">
                </div>
                <div class="portal-field">
                    <label for="student-email-{{ $course->id }}">Email address</label>
                    <input id="student-email-{{ $course->id }}" name="email" type="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" placeholder="you@example.com">
                </div>
                <div class="portal-field">
                    <label for="student-phone-{{ $course->id }}">Phone number</label>
                    <input id="student-phone-{{ $course->id }}" name="phone" type="tel" value="{{ old('phone') }}" required maxlength="30" autocomplete="tel" inputmode="tel" pattern="\+?[0-9][0-9\s\(\)\.\-]{5,28}[0-9]" placeholder="+251 9XX XXX XXX">
                </div>
                <button class="portal-register-button" type="submit">
                    <span>Register for this course</span>
                    <span aria-hidden="true">&rarr;</span>
                </button>
            </form>
        </article>
    @empty
        <div class="portal-empty-state">No courses are available at the moment. Please check again later.</div>
    @endforelse
</div>
<div id="noResults" class="portal-empty-state" hidden>No matching courses found.</div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('courseSearch');
    const cards = Array.from(document.querySelectorAll('.course-item'));
    const noResults = document.getElementById('noResults');
    const visibleCount = document.getElementById('visibleCourseCount');

    search.addEventListener('input', function () {
        const term = this.value.trim().toLowerCase();
        let visible = 0;

        cards.forEach(function (card) {
            const matches = card.dataset.courseSearch.includes(term);
            card.hidden = !matches;
            if (matches) visible++;
        });

        visibleCount.textContent = visible;
        noResults.hidden = visible !== 0 || cards.length === 0;
    });
});
</script>
@endpush
