<x-layout title="Teacher Dashboard">
    <div class="dashboard-wrapper teacher-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-left">
                <h1>Teacher Dashboard</h1>
                <p class="header-subtitle">Welcome, <strong>{{ auth()->user()->name }}</strong></p>
            </div>
            <div class="header-right">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">Logout</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
            </div>
        </div>

        <!-- Subject Setup Section -->
        @if (!$subject)
            <div class="alert alert-warning">
                <h3>📚 Set Your Subject</h3>
                <p>Please configure your subject before creating assignments.</p>
                <form method="POST" action="{{ route('teacher.setSubject') }}" class="subject-form">
                    @csrf
                    <input type="text" name="subject_name" placeholder="e.g., Mathematics, English, Science" required class="form-input">
                    <button type="submit" class="btn btn-primary">Set Subject</button>
                </form>
            </div>
        @else
            <div class="subject-card">
                    <div class="subject-info">
                        <h3>📚 Your Subject</h3>
                        <p class="subject-name">{{ $subject->name }}</p>
                        <p class="subject-code">Course code: <strong style="letter-spacing:2px;">{{ $subject->code }}</strong></p>
                        <div style="display:flex; gap:0.5rem; align-items:center; margin-top:0.5rem;">
                            <button class="btn btn-small" onclick="toggleSubjectEdit()">Change Subject</button>
                            <form method="POST" action="{{ route('teacher.regenerateCode') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-small">Regenerate Code</button>
                            </form>
                        </div>
                    </div>
                    <div id="subject-edit" style="display: none;" class="subject-edit">
                        <form method="POST" action="{{ route('teacher.setSubject') }}" class="subject-form">
                            @csrf
                            <input type="text" name="subject_name" value="{{ $subject->name }}" required class="form-input">
                            <button type="submit" class="btn btn-primary">Update Subject</button>
                        </form>
                    </div>
            </div>
        @endif

        <!-- Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($subject)
            <!-- Add Assignment Section -->
            <section class="dashboard-section">
                <div class="section-header">
                    <h2>Create New Assignment</h2>
                </div>
                <form method="POST" action="{{ route('teacher.storeAssignment') }}" class="assignment-form">
                    @csrf
                    <div class="form-group">
                        <label for="title">Assignment Title *</label>
                        <input type="text" id="title" name="title" placeholder="e.g., Chapter 5 Exercises" required class="form-input" value="{{ old('title') }}">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Detailed assignment instructions..." rows="4" class="form-input">{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="due_date">Due Date *</label>
                        <input type="datetime-local" id="due_date" name="due_date" required class="form-input" value="{{ old('due_date') }}">
                        @error('due_date') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create Assignment</button>
                </form>
            </section>

            <!-- Assignments List -->
            <section class="dashboard-section full-width">
                <div class="section-header">
                    <h2>Your Assignments ({{ count($assignments) }})</h2>
                </div>

                @if (count($assignments) > 0)
                    <div class="assignments-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Due Date</th>
                                    <th>Created</th>
                                    <th>Submissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assignments as $assignment)
                                    <tr>
                                        <td>
                                            <strong>{{ $assignment->title }}</strong>
                                            @if ($assignment->description)
                                                <p class="assignment-desc">{{ Str::limit($assignment->description, 50) }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="due-date">{{ $assignment->due_date->format('M d, Y H:i') }}</span>
                                            @if ($assignment->due_date->isPast())
                                                <span class="badge badge-red">Overdue</span>
                                            @elseif ($assignment->due_date->diffInDays(now()) <= 1)
                                                <span class="badge badge-yellow">Due Soon</span>
                                            @endif
                                        </td>
                                        <td>{{ $assignment->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="submission-count">{{ count($assignment->grades) }} graded</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-small" onclick="openEditModal({{ $assignment->id }}, '{{ addslashes($assignment->title) }}', '{{ addslashes($assignment->description) }}', '{{ $assignment->due_date->format('Y-m-d\TH:i') }}')">Edit</button>
                                                <button class="btn btn-small btn-grade" onclick="openGradeModal({{ $assignment->id }}, '{{ addslashes($assignment->title) }}')">Grade</button>
                                                <form method="POST" action="{{ route('teacher.destroyAssignment', $assignment) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-small btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="empty-state">No assignments yet. Create your first assignment above!</p>
                @endif
            </section>
        @endif
    </div>

    <!-- Edit Assignment Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Assignment</h2>
            <form id="editForm" method="POST" style="display:none;">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="edit-title">Title</label>
                    <input type="text" id="edit-title" name="title" required class="form-input">
                </div>
                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <textarea id="edit-description" name="description" rows="4" class="form-input"></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-due-date">Due Date</label>
                    <input type="datetime-local" id="edit-due-date" name="due_date" required class="form-input">
                </div>
                <button type="submit" class="btn btn-primary">Update Assignment</button>
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Grade Assignment Modal -->
    <div id="gradeModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeGradeModal()">&times;</span>
            <h2>Grade Assignment: <span id="gradingTitle"></span></h2>
            <form id="gradeForm" method="POST" style="display:none;">
                @csrf
                <div class="form-group">
                    <label for="student-id">Select Student</label>
                    <select id="student-id" name="student_id" required class="form-input">
                        <option value="">-- Select a student --</option>
                        @foreach (App\Models\User::where('role', 'student')->get() as $student)
                            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="grade">Grade (0-100) *</label>
                    <input type="number" id="grade" name="grade" min="0" max="100" step="0.5" required class="form-input" placeholder="85">
                </div>
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea id="feedback" name="feedback" rows="4" class="form-input" placeholder="Provide feedback for the student..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save Grade</button>
                <button type="button" class="btn btn-secondary" onclick="closeGradeModal()">Cancel</button>
            </form>
        </div>
    </div>

    <style>
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem;
        background: #ffffff;
        color: #1a1a1a;
    }

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

    /* Subject Card */
    .subject-card {
        background: linear-gradient(135deg, #dbeafe, #e0e7ff);
        border: 2px solid #3b82f6;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .subject-info h3 {
        margin: 0 0 0.5rem;
        font-size: 1rem;
        color: #0b1220;
    }

    .subject-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e40af;
        margin: 0 0 1rem;
    }

    .subject-edit {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(59,130,246,0.3);
    }

    /* Alerts */
    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
    }

    .alert-warning {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        color: #92400e;
    }

    .alert-danger {
        background: #fee2e2;
        border: 2px solid #ef4444;
        color: #991b1b;
    }

    .alert-success {
        background: #d1fae5;
        border: 2px solid #10b981;
        color: #065f46;
    }

    .alert h3 {
        margin: 0 0 0.5rem;
    }

    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    /* Forms */
    .assignment-form,
    .subject-form {
        display: grid;
        gap: 1rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 0.4rem;
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
    }

    .form-input {
        padding: 0.75rem;
        border: 2px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        color: #1a1a1a;
        background: #ffffff;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }

    .form-input::placeholder {
        color: #9ca3af;
    }

    .error {
        color: #dc2626;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

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

    .btn-primary {
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: #fff;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.3);
    }

    .btn-secondary {
        background: #e5e7eb;
        color: #1a1a1a;
        border: 2px solid #d1d5db;
    }

    .btn-secondary:hover {
        background: #d1d5db;
    }

    .btn-danger {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #fecaca;
    }

    .btn-danger:hover {
        background: #fecaca;
    }

    .btn-small {
        padding: 0.4rem 0.75rem;
        font-size: 0.8rem;
        background: #3b82f6;
        color: #fff;
    }

    .btn-small:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(59,130,246,0.2);
    }

    .btn-grade {
        background: #10b981;
    }

    .btn-grade:hover {
        background: #059669;
    }

    /* Tables */
    .assignments-table table {
        width: 100%;
        border-collapse: collapse;
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
    }

    .assignments-table thead {
        background: #3b82f6;
    }

    .assignments-table th {
        padding: 1rem;
        text-align: left;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .assignments-table td {
        padding: 1rem;
        color: #1a1a1a;
        border-top: 1px solid #e5e7eb;
    }

    .assignments-table tr:hover {
        background: #f9fafb;
    }

    .assignment-desc {
        margin: 0.25rem 0 0;
        color: #6b7280;
        font-size: 0.85rem;
    }

    .due-date {
        font-weight: 500;
        color: #0b1220;
    }

    .submission-count {
        background: #dbeafe;
        color: #1e40af;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .action-buttons form {
        display: inline;
    }

    .empty-state {
        text-align: center;
        color: #6b7280;
        padding: 2rem;
        font-size: 1rem;
    }

    /* Section */
    .dashboard-section {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .dashboard-section.full-width {
        grid-column: 1 / -1;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .section-header h2 {
        margin: 0;
        font-size: 1.25rem;
        color: #0b1220;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 0.5rem;
    }

    .badge-yellow { background: #fed7aa; color: #92400e; }
    .badge-red { background: #fee2e2; color: #991b1b; }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #ffffff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content h2 {
        margin: 0 0 1.5rem;
        color: #0b1220;
    }

    .close {
        float: right;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }

    .close:hover {
        color: #1a1a1a;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }

        .action-buttons .btn {
            width: 100%;
            text-align: center;
        }

        .assignments-table {
            font-size: 0.85rem;
        }

        .assignments-table th,
        .assignments-table td {
            padding: 0.5rem;
        }
    }

    @media (max-width: 480px) {
        .dashboard-wrapper {
            padding: 1rem;
        }

        .modal-content {
            width: 95%;
            padding: 1.5rem;
        }

        .assignment-form,
        .subject-form {
            grid-template-columns: 1fr;
        }
    }
    </style>

    <script>
    function openEditModal(id, title, description, dueDate) {
        const modal = document.getElementById('editModal');
        const form = document.getElementById('editForm');
        form.action = '/teacher/assignment/' + id;
        document.getElementById('edit-title').value = title;
        document.getElementById('edit-description').value = description;
        document.getElementById('edit-due-date').value = dueDate;
        form.style.display = 'block';
        modal.classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    function openGradeModal(id, title) {
        const modal = document.getElementById('gradeModal');
        const form = document.getElementById('gradeForm');
        form.action = '/teacher/grade/' + id;
        document.getElementById('gradingTitle').textContent = title;
        form.style.display = 'block';
        modal.classList.add('active');
    }

    function closeGradeModal() {
        document.getElementById('gradeModal').classList.remove('active');
    }

    function toggleSubjectEdit() {
        const subjectEdit = document.getElementById('subject-edit');
        subjectEdit.style.display = subjectEdit.style.display === 'none' ? 'block' : 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        let editModal = document.getElementById('editModal');
        let gradeModal = document.getElementById('gradeModal');
        if (event.target === editModal) {
            editModal.classList.remove('active');
        }
        if (event.target === gradeModal) {
            gradeModal.classList.remove('active');
        }
    }
    </script>
</x-layout>
