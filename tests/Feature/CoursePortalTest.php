<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Registration;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CoursePortalTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_displays_course_details_and_availability(): void
    {
        $course = $this->createCourse();

        $this->get('/')
            ->assertOk()
            ->assertSee('Find Your')
            ->assertSee('Next Course')
            ->assertSee('Available Courses')
            ->assertSee($course->name)
            ->assertSee('5,000.00');
    }

    public function test_registration_validates_fields_and_phone_format(): void
    {
        $course = $this->createCourse();

        $this->post(route('courses.register', $course), [])
            ->assertSessionHasErrors(['name', 'email', 'phone']);

        $this->post(route('courses.register', $course), [
            'name' => 'A Student',
            'email' => 'student@example.com',
            'phone' => 'not-a-phone',
        ])->assertSessionHasErrors('phone');

        $this->post(route('courses.register', $course), [
            'name' => 'A Student',
            'email' => 'student@example.com',
            'phone' => '+251 911 234 567',
        ])->assertRedirect(route('home'));

        $this->assertDatabaseHas('registrations', [
            'course_id' => $course->id,
            'email' => 'student@example.com',
        ]);
    }

    public function test_registration_prevents_same_course_duplicates_but_allows_other_courses(): void
    {
        $firstCourse = $this->createCourse();
        $secondCourse = $this->createCourse(['name' => 'Python Programming']);
        $registration = [
            'name' => 'A Student',
            'email' => 'Student@Example.com',
            'phone' => '0911234567',
        ];

        $this->post(route('courses.register', $firstCourse), $registration)
            ->assertRedirect(route('home'));

        $this->post(route('courses.register', $firstCourse), [
            ...$registration,
            'email' => 'student@example.com',
        ])->assertSessionHasErrors('email');

        $this->post(route('courses.register', $secondCourse), [
            ...$registration,
            'email' => 'student@example.com',
        ])->assertRedirect(route('home'));

        $this->assertSame(2, Registration::count());
        $this->assertDatabaseHas('registrations', ['email' => 'student@example.com']);
    }

    public function test_admin_dashboard_rejects_non_admin_users(): void
    {
        $student = $this->createUser(false);

        $this->actingAs($student)
            ->get('/dashboard')
            ->assertForbidden();

        $this->get(route('admin.courses.index'))->assertForbidden();
        $this->get(route('admin.registrations.index'))->assertForbidden();
    }

    public function test_admin_seeder_does_not_overwrite_an_existing_account(): void
    {
        config([
            'course-portal.admin.email' => 'admin@example.com',
            'course-portal.admin.password' => 'new-password',
        ]);

        $admin = User::create([
            'name' => 'Existing Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('original-password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        $this->seed(AdminUserSeeder::class);

        $admin->refresh();

        $this->assertSame('Existing Administrator', $admin->name);
        $this->assertTrue(Hash::check('original-password', $admin->password));
    }

    public function test_admin_can_log_in_view_dashboard_and_log_out(): void
    {
        $admin = $this->createUser(true);
        $this->createCourse();

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'correct-password',
        ])->assertRedirect();

        $this->assertAuthenticatedAs($admin);
        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Total Courses')
            ->assertSee('Total Registrations')
            ->assertSee('Manage Courses')
            ->assertSee('Student Registrations');

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_admin_can_manage_courses_and_validation_is_applied(): void
    {
        $this->actingAs($this->createUser(true));

        $this->post(route('admin.courses.store'), [
            'name' => '',
            'description' => str_repeat('x', 5001),
            'price' => -1,
        ])->assertSessionHasErrors(['name', 'description', 'price']);

        $this->post(route('admin.courses.store'), [
            'name' => 'Web Development',
            'description' => 'Practical web development.',
            'price' => 5000,
        ])->assertRedirect(route('admin.courses.index'));

        $course = Course::query()->where('name', 'Web Development')->firstOrFail();

        $this->get(route('admin.courses.index'))
            ->assertOk()
            ->assertSee($course->name);

        $this->patch(route('admin.courses.update', $course), [
            'name' => 'Full Stack Development',
            'description' => 'Updated course description.',
            'price' => 5200,
        ])->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Full Stack Development',
            'price' => '5200.00',
        ]);

        $this->delete(route('admin.courses.destroy', $course))
            ->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_admin_can_view_registration_details(): void
    {
        $this->actingAs($this->createUser(true));
        $course = $this->createCourse();
        $course->registrations()->create([
            'name' => 'A Student',
            'email' => 'student@example.com',
            'phone' => '0911234567',
        ]);

        $this->get(route('admin.registrations.index'))
            ->assertOk()
            ->assertSee('A Student')
            ->assertSee('student@example.com')
            ->assertSee('0911234567')
            ->assertSee($course->name);
    }

    public function test_courses_api_returns_json_with_course_fees(): void
    {
        $course = $this->createCourse();

        $response = $this->getJson('/api/courses')
            ->assertOk()
            ->assertJsonPath('0.name', $course->name);

        $this->assertEquals(5000, (float) $response->json('0.price'));
    }

    private function createCourse(array $overrides = []): Course
    {
        return Course::create(array_merge([
            'name' => 'Web Development',
            'description' => 'Learn practical web development.',
            'price' => 5000,
        ], $overrides));
    }

    private function createUser(bool $isAdmin): User
    {
        return User::create([
            'name' => $isAdmin ? 'Portal Administrator' : 'A Student',
            'email' => $isAdmin ? 'admin@example.com' : 'student-user@example.com',
            'password' => Hash::make('correct-password'),
            'is_admin' => $isAdmin,
            'email_verified_at' => now(),
        ]);
    }
}
