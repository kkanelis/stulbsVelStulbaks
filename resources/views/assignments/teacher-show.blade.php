<x-layout :title="'Assignment: ' . $assignment->title . ' (Teacher View)'">
    <div class="dashboard-wrapper">
        <div class="dashboard-header">
            <div class="header-left">
                <h1>{{ $assignment->title }}</h1>
                <p class="header-subtitle">Course: <strong>{{ optional($subject)->name }}</strong> — Due: <strong>{{ optional($assignment->due_date)->format('Y-m-d') }}</strong></p>
            </div>
            <div class="header-right">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="content-grid">
            <section class="dashboard-section full-width">
                <div class="section-header">
                    <h2>Description & Instructions</h2>
                </div>

                <div class="course-card">
                    <p class="course-detail-desc">{!! nl2br(e($assignment->description)) !!}</p>
                </div>

                <!-- Teacher Resources Section -->
                <div style="margin-top:1.5rem;padding:1rem;background:#eef2ff;border-radius:10px;border:1px solid rgba(37,99,235,0.1)">
                    <h3 style="margin-top:0;color:var(--accent)">📚 Resources for Students</h3>
                    @php $teacherFiles = $files->where('user_id', auth()->id()); @endphp
                    @if($teacherFiles->isEmpty())
                        <p style="color:var(--muted)">No resources uploaded yet.</p>
                    @else
                        @foreach($teacherFiles as $f)
                            <div class="assignment-item" style="margin-bottom:0.5rem">
                                <div style="flex:1">
                                    <a href="{{ route('file.download', $f->id) }}" style="color:var(--accent);text-decoration:none;font-weight:600">📥 {{ $f->original_name }}</a>
                                    <div style="color:var(--muted);font-size:13px;margin-top:0.25rem">{{ $f->created_at->diffForHumans() }}</div>
                                </div>
                                <div style="min-width:120px;text-align:right;color:var(--muted);font-size:0.9rem">{{ round($f->size/1024, 1) }} KB</div>
                            </div>
                        @endforeach
                    @endif

                    <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data" style="margin-top:0.75rem;border-top:1px solid rgba(37,99,235,0.1);padding-top:0.75rem">
                        @csrf
                        <div class="auth-field">
                            <label for="teacher-file">Add a new resource</label>
                            <input type="file" name="file" id="teacher-file" required style="padding:0.6rem !important">
                        </div>
                        <button class="btn btn-primary" type="submit" style="font-size:0.9rem">Upload Resource</button>
                    </form>
                </div>

                <!-- Student Submissions Section -->
                <div style="margin-top:1.5rem">
                    <h2>Student Submissions & Grades</h2>
                    @if($students->isEmpty())
                        <div class="course-card">No students enrolled in this course.</div>
                    @else
                        @foreach($students as $student)
                            @php $submissions = $files->where('user_id', $student->id); $grade = $student->grades->first(); @endphp
                            <div class="course-card" style="margin-bottom:1rem;border:1px solid rgba(15,23,42,0.06)">
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:0.75rem">
                                    <div>
                                        <h4 style="margin:0;color:#0b1220">{{ $student->name }}</h4>
                                        <p style="margin:0.25rem 0 0;color:var(--muted);font-size:0.9rem">{{ $student->email }}</p>
                                    </div>
                                    <div style="text-align:right">
                                        @if($grade)
                                            <div class="badge badge-green">Grade: {{ $grade->grade }}/100</div>
                                        @else
                                            <div class="badge badge-yellow">Not Graded</div>
                                        @endif
                                    </div>
                                </div>

                                @if($submissions->isEmpty())
                                    <p style="color:var(--muted);font-size:0.9rem">No submission yet.</p>
                                @else
                                    <div style="background:#f9fafb;padding:0.75rem;border-radius:8px;margin-top:0.5rem">
                                        <p style="margin:0 0 0.5rem;color:var(--muted);font-size:0.85rem;font-weight:600">Submissions:</p>
                                        @foreach($submissions as $sub)
                                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.4rem">
                                                <a href="{{ route('file.download', $sub->id) }}" style="color:var(--accent);text-decoration:none;font-size:0.9rem">📥 {{ $sub->original_name }}</a>
                                                <span style="color:var(--muted);font-size:0.8rem">{{ $sub->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        </div>
    </div>
</x-layout>
