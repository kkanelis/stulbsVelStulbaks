<x-layout :title="'Course: ' . $subject->name">
    <div class="dashboard-wrapper">
        <div class="dashboard-header">
            <div class="header-left">
                <h1>{{ $subject->name }}</h1>
                <p class="header-subtitle">Teacher: <strong>{{ optional($subject->teacher)->name ?? '—' }}</strong> — Code: <strong>{{ $subject->code }}</strong></p>
            </div>
            <div class="header-right">
                <a href="{{ route('dashboard.student') }}" class="btn btn-secondary">Back to Dashboard</a>
            </div>
        </div>

        <div class="content-grid">
            <section class="dashboard-section full-width">
                <div class="section-header">
                    <h2>Assignments</h2>
                    <a href="#" class="link-small">Export</a>
                </div>

                @if($assignments->isEmpty())
                    <div class="course-card">No assignments yet for this course.</div>
                @else
                    @foreach($assignments as $assignment)
                        <div class="assignment-item">
                            <div class="assignment-icon">📝</div>
                            <div class="assignment-details">
                                <h4><a href="{{ route('assignment.show', $assignment->id) }}" style="color:inherit; text-decoration:none">{{ $assignment->title }}</a></h4>
                                <p class="assignment-course">Course: {{ $subject->name }}</p>
                                <p class="assignment-due">Due: {{ optional($assignment->due_date)->format('Y-m-d') ?? 'No due date' }}</p>
                                <p class="assignment-course" style="margin-top:0.4rem;">Teacher: {{ optional($assignment->teacher)->name ?? '—' }}</p>
                            </div>
                            <div class="assignment-status">
                                @php $grade = $assignment->grades->first(); @endphp
                                @if($grade)
                                    <div class="badge badge-green">Grade: {{ $grade->grade }}</div>
                                @else
                                    <div class="badge badge-yellow">Ungraded</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </section>
        </div>
    </div>
</x-layout>
