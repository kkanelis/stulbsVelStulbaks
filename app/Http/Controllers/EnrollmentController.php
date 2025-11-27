<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function joinCourse(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $student = Auth::user();
        $subject = Subject::where('code', $request->input('code'))->first();

        if (! $subject) {
            return back()->withErrors(['code' => 'Invalid course code.']);
        }

        // Attach student if not already attached
        $subject->students()->syncWithoutDetaching([$student->id]);

        return back()->with('success', 'You have joined the course: ' . $subject->name);
    }

    // Show a course and its assignments/grades for the current student
    public function showCourse(Subject $subject)
    {
        $student = Auth::user();

        // Ensure the user is enrolled in this subject (or is the teacher)
        $enrolled = $subject->students()->where('users.id', $student->id)->exists();
        $isTeacher = $subject->teacher_id === $student->id;

        if (! $enrolled && ! $isTeacher) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Load assignments with grades for this student
        $assignments = $subject->assignments()->with(['grades' => function($q) use ($student) {
            $q->where('student_id', $student->id);
        }])->orderBy('due_date', 'asc')->get();

        return view('courses.show', compact('subject', 'assignments'));
    }
}
