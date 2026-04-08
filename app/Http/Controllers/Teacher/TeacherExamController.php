<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Test;
use App\Models\TestQuestion;
use App\Models\TestOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherExamController extends Controller
{
    /**
     * Show the create exam form.
     */
    public function create()
    {
        $teacher  = Auth::user();
        $profile  = $teacher->teacherProfile;

        // Subjects this teacher teaches (array from JSON column)
        $subjects = $profile?->subjects ?? [];

        // All classes available to assign the exam to
        $classes  = SchoolClass::orderBy('name')->get();

        return view('teacher.create-exam', compact('subjects', 'classes'));
    }

    /**
     * Save the exam and all its questions + options.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'subject'          => ['required', 'string'],
            'class_id'         => ['required', 'exists:school_classes,id'],
            'duration_minutes' => ['required', 'integer', 'min:5', 'max:180'],
            'questions'        => ['required', 'array', 'min:1'],
            'questions.*.question_text'   => ['required', 'string'],
            'questions.*.options'         => ['required', 'array', 'size:4'],
            'questions.*.options.*'       => ['required', 'string'],
            'questions.*.correct_option'  => ['required', 'integer', 'between:0,3'],
        ]);

        DB::transaction(function () use ($request) {
            $teacher = Auth::user();

            // Create the test
            $test = Test::create([
                'teacher_id'       => $teacher->id,
                'class_id'         => $request->class_id,
                'subject'          => $request->subject,
                'title'            => $request->title,
                'duration_minutes' => $request->duration_minutes,
                'is_active'        => $request->boolean('is_active'),
            ]);

            // Create each question and its options
            foreach ($request->questions as $order => $qData) {
                $question = TestQuestion::create([
                    'test_id'       => $test->id,
                    'question_text' => $qData['question_text'],
                    'order'         => $order,
                ]);

                foreach ($qData['options'] as $index => $optionText) {
                    TestOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'is_correct'  => ((int) $qData['correct_option'] === (int) $index),
                    ]);
                }
            }
        });

        return redirect()->route('teacher.exams.index')
            ->with('success', 'Exam created successfully!');
    }

    /**
     * List all exams created by this teacher.
     */
    public function index()
    {
        $teacher = Auth::user();

        $exams = Test::where('teacher_id', $teacher->id)
            ->with('schoolClass')
            ->withCount('questions', 'submissions')
            ->latest()
            ->get();

        return view('teacher.exams', compact('exams'));
    }

    /**
     * Toggle exam active/inactive.
     */
    public function toggleActive(int $id)
    {
        $teacher = Auth::user();

        $exam = Test::where('id', $id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $exam->update(['is_active' => !$exam->is_active]);

        $status = $exam->is_active ? 'activated' : 'deactivated';

        return back()->with('success', "Exam {$status} successfully.");
    }

    /**
     * Delete an exam (cascades to questions, options, submissions).
     */
    public function destroy(int $id)
    {
        $teacher = Auth::user();

        Test::where('id', $id)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail()
            ->delete();

        return back()->with('success', 'Exam deleted successfully.');
    }
}