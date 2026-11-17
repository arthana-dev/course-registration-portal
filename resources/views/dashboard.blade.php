
<x-app-layout>

    <x-slot name="header">
        <h2 style="font-size:24px; font-weight:700; color:#172b4d;">
            Admin Dashboard
        </h2>
    </x-slot>

    <style>
        .admin-dashboard {
            max-width: 1200px;
            margin: auto;
            padding: 35px 20px;
        }

        .welcome-banner {
            background: linear-gradient(120deg, #142d4e, #2878a8);
            color: white;
            padding: 35px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .welcome-banner h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome-banner p {
            color: #e2edf7;
            font-size: 16px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);
            border: 1px solid #e8edf3;
        }

        .stat-card .stat-icon {
            font-size: 30px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 8px;
        }

        .stat-card .number {
            font-size: 30px;
            font-weight: 700;
            color: #172b4d;
        }

        .section-heading {
            font-size: 22px;
            font-weight: 700;
            color: #172b4d;
            margin-bottom: 18px;
        }

        .action-card {
            display: block;
            text-decoration: none;
            background: white;
            border: 1px solid #e5eaf1;
            border-radius: 14px;
            padding: 26px;
            box-shadow: 0 4px 14px rgba(0,0,0,.05);
            transition: .2s;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 9px 22px rgba(0,0,0,.10);
        }

        .action-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            margin-bottom: 18px;
        }

        .blue-icon { background: #e4efff; }
        .green-icon { background: #dcfce7; }
        .purple-icon { background: #f0e8ff; }

        .action-card h3 {
            color: #172b4d;
            font-size: 19px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .action-card p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        .action-link {
            display: inline-block;
            color: #2563eb;
            font-weight: 600;
            margin-top: 15px;
        }

        @media (max-width: 600px) {
            .welcome-banner { padding: 25px; }
            .welcome-banner h1 { font-size: 24px; }
        }
    </style>

    <div style="background:#f4f7fb; min-height:85vh;">
        <div class="admin-dashboard">

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <h1>Welcome back, Portal Administrator! 👋</h1>
                <p>
                    Manage your courses, monitor student registrations
                    and control your Course Registration Portal.
                </p>
            </div>

            <!-- Statistics -->
            <div class="dashboard-grid">

                <div class="stat-card">
                    <div class="stat-icon">📚</div>
                    <h3>Total Courses</h3>
                    <div class="number">{{ $totalCourses }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👨‍🎓</div>
                    <h3>Total Registrations</h3>
                    <div class="number">{{ $totalRegistrations }}</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">👤</div>
                    <h3>Administrator</h3>
                    <div class="number" style="font-size:20px;">
                        Active
                    </div>
                </div>

            </div>

            <!-- Quick Actions -->
            <h2 class="section-heading">Quick Actions</h2>

            <div class="dashboard-grid">

                <a href="{{ route('admin.courses.index') }}"
                   class="action-card">
                    <div class="action-icon blue-icon">📚</div>
                    <h3>Manage Courses</h3>
                    <p>
                        Add new courses, update course details,
                        manage fees and remove courses.
                    </p>
                    <span class="action-link">Manage courses →</span>
                </a>

                <a href="{{ route('admin.registrations.index') }}"
                   class="action-card">
                    <div class="action-icon green-icon">👨‍🎓</div>
                    <h3>Student Registrations</h3>
                    <p>
                        View registered students and check their
                        contact details and selected courses.
                    </p>
                    <span class="action-link">View registrations →</span>
                </a>

                <a href="{{ route('home') }}"
                   class="action-card">
                    <div class="action-icon purple-icon">🌐</div>
                    <h3>Public Course Portal</h3>
                    <p>
                        Visit the public website to view available
                        courses and test student registration.
                    </p>
                    <span class="action-link">Visit portal →</span>
                </a>

            </div>

        </div>
    </div>

</x-app-layout>
