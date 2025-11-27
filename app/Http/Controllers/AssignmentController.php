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

        $files = $assignment->files()->with('user')->get();

        // If teacher: get student submissions and all enrolled students
        if ($isTeacher) {
            $students = $subject->students()->with(['grades' => function($q) use ($assignment) {
                $q->where('assignment_id', $assignment->id);
            }])->get();

            return view('assignments.teacher-show', compact('assignment', 'files', 'students', 'subject'));
        }

        return view('assignments.show', compact('assignment', 'files', 'isTeacher'));
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
            'file' => 'required|file|max:10240', // max 10MB
            'note' => 'nullable|string|max:1000',
        ]);

        $file = $request->file('file');
        $path = $file->storeAs('assignments', Str::random(12) . '_' . $file->getClientOriginalName(), 'public');

        AssignmentFile::create([
            'assignment_id' => $assignment->id,
            'user_id' => $user->id,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);

        return back()->with('success', 'File uploaded successfully.');
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
