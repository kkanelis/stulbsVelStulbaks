<x-layout title="Teacher Dashboard">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">🎓 Skolotāja Panelis</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 1rem;">Sveiki, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">🚪 Iziet</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Subject Setup Section -->
            <!-- Subject Setup Section -->
            @if (!$subject)
                <div style="background: linear-gradient(135deg, #ffd699 0%, #ffcc80 100%); border-left: 4px solid #f59e0b; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;">
                    <h3 style="color: #8B5E00; margin: 0 0 1rem 0; font-weight: 800;">📚 Iestatīt Jūsu Kursu</h3>
                    <p style="color: #7D6608; margin: 0 0 1.5rem 0;">Lūdzu konfigurējiet savu kursu pirms uzdevumu izveidošanas.</p>
                    <form method="POST" action="{{ route('teacher.setSubject') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
                        @csrf
                        <div style="flex: 1;">
                            <input type="text" name="subject_name" placeholder="Piem.: Matemātika, Angļu valoda, Zinātne" required style="width: 100%; padding: 0.9rem 1rem; border: 2px solid #F59E0B; border-radius: 10px; color: #1B262C; font-size: 1rem;">
                        </div>
                        <button type="submit" style="background: #0F4C75; color: white; padding: 0.9rem 2rem; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s ease;">➕ Iestatīt</button>
                    </form>
                </div>
            @else
                <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(15, 76, 117, 0.2);">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3 style="color: #BBE1FA; margin: 0 0 0.5rem 0; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">📚 Jūsu Kurss</h3>
                            <p style="margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 800;">{{ $subject->name }}</p>
                            <p style="margin: 0; color: #BBE1FA; font-family: monospace; font-size: 1.1rem; letter-spacing: 2px;">{{ $subject->code }}</p>
                        </div>
                        <div style="display: flex; gap: 0.75rem; flex-direction: column; align-items: flex-end;">
                            <button onclick="toggleSubjectEdit()" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.3); font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)';">✏️ Mainīt</button>
                            <form method="POST" action="{{ route('teacher.regenerateCode') }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background: rgba(255, 255, 255, 0.2); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.3); font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255, 255, 255, 0.3)';" onmouseout="this.style.background='rgba(255, 255, 255, 0.2)';">🔄 Ģenerēt jaunu kodu</button>
                            </form>
                        </div>
                    </div>
                    <div id="subject-edit" style="display: none; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.2);">
                        <form method="POST" action="{{ route('teacher.setSubject') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
                            @csrf
                            <div style="flex: 1;">
                                <label style="color: #BBE1FA; display: block; margin-bottom: 0.5rem; font-weight: 600;">Jauns kursa nosaukums</label>
                                <input type="text" name="subject_name" value="{{ $subject->name }}" required style="width: 100%; padding: 0.8rem 1rem; border: 2px solid #BBE1FA; border-radius: 8px; color: #1B262C;">
                            </div>
                            <button type="submit" style="background: #BBE1FA; color: #0F4C75; padding: 0.8rem 1.5rem; border-radius: 8px; border: none; font-weight: 700; cursor: pointer;">Atjaunināt</button>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Messages -->
            @if ($errors->any())
                <div style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left: 4px solid #f44336; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; color: #c62828;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 0.5rem 0; font-weight: 600;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div style="background: linear-gradient(135deg, #e8f5e9 0%, #d4edda 100%); border-left: 4px solid #4caf50; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; color: #2e7d32; font-weight: 600;">
                    ✅ {{ session('success') }}
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
    body { background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%); }
    
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(27, 38, 44, 0.1);
    }

    .header-left h1 {
        margin: 0;
        font-size: 2rem;
        color: #0F4C75;
    }

    .header-subtitle {
        margin: 0.5rem 0 0;
        color: #666;
        font-size: 0.95rem;
    }

    .header-right {
        display: flex;
        gap: 0.75rem;
    }

    /* Subject Card */
    .subject-card {
        background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%);
        border: none;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: 0 10px 30px rgba(15, 76, 117, 0.2);
    }

    .subject-info h3 {
        margin: 0 0 0.5rem;
        font-size: 0.9rem;
        color: #BBE1FA;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .subject-name {
        font-size: 1.8rem;
        font-weight: 700;
        color: white;
        margin: 0 0 1rem;
    }

    .subject-code {
        color: #BBE1FA;
        font-size: 0.95rem;
    }

    .subject-edit {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Alerts */
    .alert {
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        border-left: 4px solid;
    }

    .alert-warning {
        background: #fff8e1;
        border-left-color: #FFC107;
        color: #7D6608;
    }

    .alert-danger {
        background: #ffebee;
        border-left-color: #f44336;
        color: #c62828;
    }

    .alert-success {
        background: #e8f5e9;
        border-left-color: #4caf50;
        color: #2e7d32;
    }

    .alert h3 {
        margin: 0 0 0.75rem;
    }

    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }

    /* Forms */
    .assignment-form,
    .subject-form {
        display: grid;
        gap: 1.25rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #1B262C;
        font-size: 0.95rem;
    }

    .form-input {
        padding: 0.875rem;
        border: 2px solid #E0E7FF;
        border-radius: 8px;
        font-size: 1rem;
        color: #1B262C;
        background: white;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #0F4C75;
        box-shadow: 0 0 0 4px rgba(15, 76, 117, 0.1);
        background: white;
    }

    .form-input::placeholder {
        color: #999;
    }

    .error {
        color: #d32f2f;
        font-size: 0.85rem;
        margin-top: 0.35rem;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(15, 76, 117, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #0F4C75;
        border: 2px solid #0F4C75;
    }

    .btn-secondary:hover {
        background: #F0F4F8;
    }

    .btn-danger {
        background: #ffcdd2;
        color: #c62828;
        border: none;
    }

    .btn-danger:hover {
        background: #ef9a9a;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        background: #3282B8;
        color: white;
    }

    .btn-small:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(50, 130, 184, 0.3);
    }

    .btn-grade {
        background: #4caf50;
    }

    .btn-grade:hover {
        background: #45a049;
        box-shadow: 0 4px 12px rgba(76, 175, 80, 0.3);
    }

    /* Tables */
    .assignments-table table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(27, 38, 44, 0.1);
    }

    .assignments-table thead {
        background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%);
    }

    .assignments-table th {
        padding: 1.25rem;
        text-align: left;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .assignments-table td {
        padding: 1.25rem;
        color: #1B262C;
        border-top: 1px solid #f0f0f0;
    }

    .assignments-table tr:hover {
        background: #f8f9fa;
    }

    .assignment-desc {
        margin: 0.5rem 0 0;
        color: #666;
        font-size: 0.85rem;
    }

    .due-date {
        font-weight: 600;
        color: #0F4C75;
    }

    .submission-count {
        background: linear-gradient(135deg, #BBE1FA 0%, #E0E7FF 100%);
        color: #0F4C75;
        padding: 0.4rem 0.75rem;
        border-radius: 6px;
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
        color: #999;
        padding: 3rem 1.5rem;
        font-size: 1rem;
    }

    /* Section */
    .dashboard-section {
        background: white;
        border: none;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px rgba(27, 38, 44, 0.1);
    }

    .dashboard-section.full-width {
        grid-column: 1 / -1;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #0F4C75;
    }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 0.5rem;
    }

    .badge-yellow { background: #ffd699; color: #8B5E00; }
    .badge-red { background: #ffcccc; color: #990000; }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(27, 38, 44, 0.15);
        max-width: 500px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-content h2 {
        margin: 0 0 1.5rem;
        color: #0F4C75;
    }

    .close {
        float: right;
        font-size: 1.8rem;
        cursor: pointer;
        color: #999;
        transition: color 0.2s ease;
    }

    .close:hover {
        color: #1B262C;
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
            font-size: 0.9rem;
        }

        .assignments-table th,
        .assignments-table td {
            padding: 0.75rem;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .header-right {
            width: 100%;
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

        .header-left h1 {
            font-size: 1.5rem;
        }

        .section-header h2 {
            font-size: 1.25rem;
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

        </div>
    </div>

    <script>
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
