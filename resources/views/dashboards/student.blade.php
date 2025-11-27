<x-layout title="Student Dashboard">
    <div class="dashboard-wrapper">
        <!-- Header & Navigation -->
        <div class="dashboard-header">
            <div class="header-left">
                <h1>Student Dashboard</h1>
                <p class="header-subtitle">Welcome back, <strong>{{ auth()->user()->name }}</strong></p>
            </div>
            <div class="header-right">
                <button class="btn btn-secondary" onclick="document.getElementById('profile-menu').toggleAttribute('hidden')">Profile</button>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
            </div>
        </div>
        <div class="join-course" style="margin-bottom:1rem;">
            <h4>Join a course</h4>
                <form method="POST" action="{{ route('student.join') }}" style="display:flex; gap:0.5rem; align-items:center;">
            @csrf
                <input type="text" name="code" placeholder="Enter 6-letter code" maxlength="6" class="form-input" required style="width:180px; text-transform:uppercase;">
                <button type="submit" class="btn btn-primary">Join</button>
                </form>
            @if ($errors->has('code'))
                <div class="error">{{ $errors->first('code') }}</div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" style="margin-top:0.5rem;">{{ session('success') }}</div>
            @endif
         </div>
        
        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Courses Section -->

                    <section class="dashboard-section">
                        <div class="section-header">
                            <h2>My Courses</h2>
                            <a href="#" class="link-small">View All</a>
                    </div>

                    <div class="courses-grid">
                        @php $subjects = auth()->user()->enrolledSubjects()->withCount(['students'])->get(); @endphp
                        @if($subjects->isEmpty())
                            <div class="course-card">
                                <p>You are not enrolled in any courses yet. Use the join form above or ask your teacher for the 6-letter code.</p>
                            </div>
                        @else
                            
                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(260px,1fr)); gap:1rem;">
                            @foreach($subjects as $subject)
                                <a href="{{ route('student.course.show', $subject->id) }}" class="course-card" style="text-decoration:none; color:inherit;">
                                    <div class="course-header">
                                        <h3>{{ $subject->name }}</h3>
                                        <div class="badge badge-blue">Code: {{ $subject->code }}</div>
                                    </div>
                                    <p class="course-teacher">Teacher: {{ optional($subject->teacher)->name ?? '—' }}</p>
                                    <div class="progress-bar" aria-hidden>
                                        <div class="progress-fill" style="width: {{ rand(10,90) }}%;"></div>
                                    </div>
                                    <p class="progress-text">Students: {{ $subject->students_count }}</p>
                                </a>
                            @endforeach
                            </div>
                        @endif
                    </div>
        </div>
    </div>

    <style>
    /* Force light background for readability */
    body { background: #f8f9fa !important; }
    
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem;
        background: #ffffff;
        color: #1a1a1a;
    }

    /* Header */
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    .header-left h1 {
        margin: 0;
        font-size: 2rem;
        color: #0b1220;
    }
    .header-subtitle {
        margin: 0.25rem 0 0;
        color: #4b5563;
        font-size: 0.95rem;
    }
    .header-right {
        display: flex;
        gap: 0.75rem;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
        border: 2px solid #3b82f6;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        font-size: 2.5rem;
    }
    .stat-content h3 {
        margin: 0;
        font-size: 0.85rem;
        color: #4b5563;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }
    .stat-value {
        margin: 0.25rem 0 0;
        font-size: 1.75rem;
        font-weight: 700;
        color: #0b1220;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }
    .dashboard-section.full-width {
        grid-column: 1 / -1;
    }

    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .section-header h2 {
        margin: 0;
        font-size: 1.25rem;
        color: #0b1220;
    }
    .link-small {
        color: #3b82f6;
        text-decoration: none;
        font-size: 0.85rem;
        transition: color 0.2s ease;
        font-weight: 600;
    }
    .link-small:hover {
        color: #1e40af;
    }

    /* Course Cards */
    .course-card {
        background: #f9fafb;
        border: 2px solid #d1d5db;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .course-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    .course-header h3 {
        margin: 0;
        color: #0b1220;
        font-size: 1rem;
        font-weight: 600;
    }
    .course-teacher {
        margin: 0.25rem 0;
        color: #4b5563;
        font-size: 0.85rem;
    }
    .progress-bar {
        width: 100%;
        height: 6px;
        background: #e5e7eb;
        border-radius: 3px;
        overflow: hidden;
        margin: 0.75rem 0;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        transition: width 0.3s ease;
    }
    .progress-text {
        margin: 0.25rem 0 0.75rem;
        color: #4b5563;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Assignment Items */
    .assignment-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        background: #f9fafb;
        border: 2px solid #d1d5db;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 0.75rem;
    }
    .assignment-icon {
        font-size: 1.5rem;
        min-width: 2rem;
    }
    .assignment-details {
        flex: 1;
    }
    .assignment-details h4 {
        margin: 0 0 0.25rem;
        color: #0b1220;
        font-size: 0.95rem;
        font-weight: 600;
    }
    .assignment-course {
        margin: 0;
        color: #4b5563;
        font-size: 0.8rem;
        font-weight: 500;
    }
    .assignment-due {
        margin: 0.25rem 0 0;
        color: #4b5563;
        font-size: 0.8rem;
    }
    .assignment-status {
        min-width: 80px;
        text-align: right;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-blue { background: #dbeafe; color: #1e40af; }
    .badge-green { background: #d1fae5; color: #065f46; }
    .badge-yellow { background: #fed7aa; color: #92400e; }
    .badge-red { background: #fee2e2; color: #991b1b; }
    .badge-gray { background: #e5e7eb; color: #374151; }

    /* Grades Table */
    .grades-table {
        overflow-x: auto;
    }
    .grades-table table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        overflow: hidden;
    }
    .grades-table thead {
        background: #3b82f6;
    }
    .grades-table th {
        padding: 1rem;
        text-align: left;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .grades-table td {
        padding: 0.75rem 1rem;
        color: #1a1a1a;
        border-top: 1px solid #e5e7eb;
    }
    .grades-table tr:hover {
        background: #f9fafb;
    }
    .grade-A { color: #059669; font-weight: 600; }
    .grade-B { color: #3b82f6; font-weight: 600; }
    .grade-C { color: #d97706; font-weight: 600; }

    /* Buttons */
    .btn {
        padding: 0.6rem 1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .btn-small {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: #fff;
    }
    .btn-small:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }
    .btn-secondary {
        background: #e5e7eb;
        color: #1a1a1a;
        border: 2px solid #d1d5db;
        font-weight: 600;
    }
    .btn-secondary:hover {
        background: #d1d5db;
    }
    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
        font-weight: 600;
    }
    .btn-danger:hover {
        background: #fecaca;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        .header-right {
            width: 100%;
        }
        .stats-grid {
            grid-template-columns: 1fr 1fr;
        }
    }
    @media (max-width: 480px) {
        .dashboard-wrapper {
            padding: 1rem;
        }
        .header-left h1 {
            font-size: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .header-right {
            flex-direction: column;
            gap: 0.5rem;
        }
        .btn {
            width: 100%;
            text-align: center;
        }
    }
    </style>
</x-layout>
