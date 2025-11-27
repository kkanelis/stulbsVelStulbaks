<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // Show teacher dashboard
    public function dashboard()
    {
        $teacher = Auth::user();
        $subject = $teacher->subject;
        $assignments = $teacher->assignments()->latest()->get();

        return view('dashboards.teacher', compact('teacher', 'subject', 'assignments'));
    }

    // Store a new assignment
    public function storeAssignment(Request $request)
    {
        $teacher = Auth::user();
        $subject = $teacher->subject;

        if (!$subject) {
            return back()->with('error', 'Please set up your subject first.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:now',
        ]);

        Assignment::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'subject_id' => $subject->id,
            'teacher_id' => $teacher->id,
        ]);

        return back()->with('success', 'Assignment created successfully!');
    }

    // Update assignment
    public function updateAssignment(Request $request, Assignment $assignment)
    {
        // Verify the assignment belongs to the logged-in teacher
        if ($assignment->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $assignment->update($validated);

        return back()->with('success', 'Assignment updated successfully!');
    }

    // Delete assignment
    public function destroyAssignment(Assignment $assignment)
    {
        // Verify the assignment belongs to the logged-in teacher
        if ($assignment->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $assignment->delete();

        return back()->with('success', 'Assignment deleted successfully!');
    }

    // Grade assignment (for students)
    public function gradeAssignment(Request $request, Assignment $assignment)
    {
        if ($assignment->teacher_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $assignment->grades()->updateOrCreate(
            ['student_id' => $validated['student_id']],
            [
                'grade' => $validated['grade'],
                'feedback' => $validated['feedback'],
            ]
        );

        return back()->with('success', 'Grade saved successfully!');
    }

    // Update teacher subject
    public function setSubject(Request $request)
    {
        $teacher = Auth::user();

        $validated = $request->validate([
            'subject_name' => 'required|string|max:255',
        ]);

        $subject = $teacher->subject ?? new Subject();
        $isNew = !$subject->exists;
        $subject->name = $validated['subject_name'];
        $subject->teacher_id = $teacher->id;

        if ($isNew || empty($subject->code)) {
            // generate a unique 6-letter code
            $subject->code = $this->generateUniqueCode();
        }

        $subject->save();

        return back()->with('success', 'Subject updated successfully! Code: ' . $subject->code);
    }

    // Regenerate the subject join code
    public function regenerateCode(Request $request)
    {
        $teacher = Auth::user();
        $subject = $teacher->subject;

        if (!$subject) {
            return back()->with('error', 'No subject set.');
        }

        $subject->code = $this->generateUniqueCode();
        $subject->save();

        return back()->with('success', 'New course code generated: ' . $subject->code);
    }

    private function generateUniqueCode()
    {
        $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $letters[random_int(0, strlen($letters) - 1)];
            }
        } while (Subject::where('code', $code)->exists());

        return $code;
    }
}
