<x-layout :title="'Assignment: ' . $assignment->title">
    <div class="dashboard-wrapper">
        <div class="dashboard-header">
            <div class="header-left">
                <h1>{{ $assignment->title }}</h1>
                <p class="header-subtitle">Course: <strong>{{ optional($assignment->subject)->name }}</strong> — Teacher: <strong>{{ optional($assignment->teacher)->name }}</strong></p>
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
                    <p style="margin-top:0.5rem;color:var(--muted)">Due: {{ optional($assignment->due_date)->format('Y-m-d') ?? 'No due date' }}</p>
                </div>

                <div style="margin-top:1rem">
                    <h3>Files</h3>
                    @if($files->isEmpty())
                        <div class="course-card">No files uploaded yet.</div>
                    @else
                        @foreach($files as $f)
                            <div class="assignment-item">
                                <div style="flex:1">
                                    <a href="{{ route('file.download', $f->id) }}" style="color:var(--accent);text-decoration:none;font-weight:600">📥 {{ $f->original_name }}</a>
                                    <div style="color:var(--muted);font-size:13px;margin-top:0.25rem">Uploaded by: {{ optional($f->user)->name }} — {{ $f->created_at->diffForHumans() }}</div>
                                </div>
                                <div style="min-width:120px;text-align:right;color:var(--muted);font-size:0.9rem">{{ round($f->size/1024, 1) }} KB</div>
                            </div>
                        @endforeach
                    @endif
                </div>

                @if($isTeacher)
                <div style="margin-top:1.5rem;padding:1rem;background:#eef2ff;border-radius:10px;border:1px solid rgba(37,99,235,0.1)">
                    <h3 style="margin-top:0;color:var(--accent)">📚 Add Resources for Students</h3>
                    <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="auth-field">
                            <label for="teacher-file">Select file to upload</label>
                            <input type="file" name="file" id="teacher-file" required>
                        </div>
                        <div style="margin-top:0.5rem">
                            <button class="btn btn-primary" type="submit">Upload Resource</button>
                        </div>
                    </form>
                </div>
                @else
                <div style="margin-top:1.5rem">
                    <h3>Submit Your Work</h3>
                    <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="auth-field">
                            <label for="student-file">Select file</label>
                            <input type="file" name="file" id="student-file" required>
                        </div>
                        <div style="margin-top:0.5rem">
                            <button class="btn btn-primary" type="submit">Submit File</button>
                        </div>
                    </form>
                </div>
                @endif

                @if($errors->any())
                    <div class="errors" style="margin-top:0.5rem">{{ $errors->first() }}</div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success" style="margin-top:0.5rem;background:#e6ffef;border:1px solid #a1d9b8;color:#065f46;padding:0.75rem;border-radius:8px">{{ session('success') }}</div>
                @endif
            </section>
        </div>
    </div>
</x-layout>
