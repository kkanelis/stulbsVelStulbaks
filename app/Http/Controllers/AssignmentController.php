<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AssignmentController extends Controller
{
    // Show assignment detail (description, files, grade for student or teacher view with submissions)
    public function show(Assignment $assignment)
    {
        $user = Auth::user();

        // Check access: student must be enrolled or teacher owner
        $subject = $assignment->subject;
        $enrolled = $subject->students()->where('users.id', $user->id)->exists();
        $isTeacher = $assignment->teacher_id === $user->id;

        if (! $enrolled && ! $isTeacher) {
            abort(403, 'Unauthorized access to this assignment.');
        }

        // If teacher: get all files and student list with grades
        if ($isTeacher) {
            $files = $assignment->files()->with('user')->get();

            $students = $subject->students()->with(['grades' => function($q) use ($assignment) {
                $q->where('assignment_id', $assignment->id);
            }])->get();

            return view('assignments.teacher-show', compact('assignment', 'files', 'students', 'subject'));
        }

        // For students: only show their own submissions, but also provide teacher files
        $files = $assignment->files()->where('user_id', $user->id)->with('user')->get();
        $teacherFiles = $assignment->files()->where('user_id', $assignment->teacher_id)->with('user')->get();

        return view('assignments.show', compact('assignment', 'files', 'isTeacher', 'teacherFiles'));
    }

    // Upload a file for the assignment (student submission or teacher resource)
    public function upload(Request $request, Assignment $assignment)
    {
        $user = Auth::user();

        // Check access as above
        $subject = $assignment->subject;
        $enrolled = $subject->students()->where('users.id', $user->id)->exists();
        $isTeacher = $assignment->teacher_id === $user->id;

        if (! $enrolled && ! $isTeacher) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'file' => 'nullable|file|max:10240', // max 10MB, now optional
            'note' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $path = null;
        $originalName = null;
        $mime = null;
        $size = null;

        if ($file) {
            $path = $file->storeAs('assignments', Str::random(12) . '_' . $file->getClientOriginalName(), 'public');
            $originalName = $file->getClientOriginalName();
            $mime = $file->getClientMimeType();
            $size = $file->getSize();
        }

        // Only create if there's either a file or a note
        if ($file || $request->filled('note')) {
            AssignmentFile::create([
                'assignment_id' => $assignment->id,
                'user_id' => $user->id,
                'path' => $path,
                'original_name' => $originalName,
                'mime' => $mime,
                'size' => $size,
                'note' => $request->input('note'),
            ]);
        } else {
            return back()->with('error', 'Please upload a file or write a note.');
        }

        return back()->with('success', 'Submission saved successfully.');
    }

    // Download a file
    public function download(AssignmentFile $file)
    {
        $user = Auth::user();
        $assignment = $file->assignment;
        $subject = $assignment->subject;

        // Check access: student must be enrolled or teacher owner
        $enrolled = $subject->students()->where('users.id', $user->id)->exists();
        $isTeacher = $assignment->teacher_id === $user->id;

        if (! $enrolled && ! $isTeacher) {
            abort(403, 'Unauthorized.');
        }

        if (! Storage::disk('public')->exists($file->path)) {
            abort(404, 'File not found.');
        }

        return response()->download(Storage::disk('public')->path($file->path), $file->original_name);
    }
}
