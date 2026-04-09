@extends('layouts.teacher.app')

@section('title', 'My Students')

@section('content')

<div style="margin-bottom:24px;">
    <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:800;
                font-size:20px; color:var(--blue-900);">
        👥 My Students
    </div>
    <div style="font-size:13px; color:var(--gray-400); margin-top:4px;">
        View and manage students across your classes
    </div>
</div>

@if(session('success'))
    <div style="background:#dcfce7; color:#15803d; padding:12px 16px;
                border-radius:10px; margin-bottom:20px; font-size:13.5px; font-weight:500;">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- ══════════════════════════════════════════════════════
     SECTION 1: CLASS TEACHER VIEW
═══════════════════════════════════════════════════════ --}}
@if($profile?->is_class_teacher && $assignedClass)

    <div class="card" style="margin-bottom:28px;">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between;
                    flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <div>
                <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700;
                            font-size:16px; color:var(--blue-900);">
                    🏫 Class Teacher — {{ $assignedClass->name }}
                </div>
                <div style="font-size:12.5px; color:var(--gray-400); margin-top:3px;">
                    All students in your assigned class
                </div>
            </div>
            <span class="module-badge badge-green">
                {{ $classStudents->count() }} Students
            </span>
        </div>

        @if($classStudents->count() > 0)

            {{-- Search --}}
            <div style="display:flex; align-items:center; gap:8px; background:var(--gray-100);
                        border-radius:9px; padding:8px 14px; width:260px; margin-bottom:16px;">
                <span style="color:var(--gray-400);">🔍</span>
                <input type="text" placeholder="Search student…"
                       oninput="filterStudents('classTable', this.value)"
                       style="border:none; background:none; outline:none; font-size:13.5px;
                              font-family:inherit; color:var(--gray-700); width:100%;">
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:13.5px;"
                       id="classTable">
                    <thead>
                        <tr style="background:var(--blue-50); border-bottom:1px solid var(--gray-200);">
                            <th style="padding:12px 16px; text-align:left; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">#</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Student</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Student ID</th>
                            <th style="padding:12px 16px; text-align:center; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Tests Taken</th>
                            <th style="padding:12px 16px; text-align:center; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Avg. Score</th>
                            <th style="padding:12px 16px; text-align:left; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Last Active</th>
                            <th style="padding:12px 16px; text-align:center; font-weight:700;
                                       color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classStudents as $i => $student)
                            <tr class="student-row"
                                style="border-bottom:1px solid var(--gray-100); transition:background .15s;"
                                onmouseover="this.style.background='var(--blue-50)'"
                                onmouseout="this.style.background=''">
                                <td style="padding:12px 16px; color:var(--gray-400); font-size:12px;">
                                    {{ $i + 1 }}
                                </td>
                                <td style="padding:12px 16px;">
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div style="width:32px; height:32px; border-radius:8px;
                                                    background:var(--blue-700); display:flex;
                                                    align-items:center; justify-content:center;
                                                    font-weight:700; font-size:12px; color:#fff;
                                                    flex-shrink:0; font-family:'Plus Jakarta Sans',sans-serif;">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </div>
                                        <span class="student-name" style="font-weight:600; color:var(--blue-900);">
                                            {{ $student->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="student-id" style="padding:12px 16px; color:var(--gray-500);">
                                    {{ $student->student_id }}
                                </td>
                                <td style="padding:12px 16px; text-align:center;
                                           font-weight:700; color:var(--blue-900);">
                                    {{ $student->tests_taken }}
                                </td>
                                <td style="padding:12px 16px; text-align:center;">
                                    @if($student->avg_performance !== null)
                                        <span style="font-weight:700;
                                            color:{{ $student->avg_performance >= 75 ? 'var(--green)' : ($student->avg_performance >= 50 ? 'var(--blue-600)' : 'var(--red)') }}">
                                            {{ $student->avg_performance }}%
                                        </span>
                                    @else
                                        <span style="color:var(--gray-400); font-size:12px;">No tests yet</span>
                                    @endif
                                </td>
                                <td style="padding:12px 16px; color:var(--gray-400); font-size:12.5px;">
                                    {{ $student->last_submission ? $student->last_submission->diffForHumans() : '—' }}
                                </td>
                                <td style="padding:12px 16px; text-align:center;">
                                    <a href="{{ route('teacher.students.show', $student->id) }}"
                                       style="padding:6px 13px; border-radius:7px; font-size:12px;
                                              font-weight:600; text-decoration:none;
                                              background:var(--blue-50); color:var(--blue-600);
                                              border:1.5px solid var(--blue-100);">
                                        👁 View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>No students in {{ $assignedClass->name }} yet.</p>
            </div>
        @endif
    </div>

@endif

{{-- ══════════════════════════════════════════════════════
     SECTION 2: SUBJECT TEACHER VIEW
═══════════════════════════════════════════════════════ --}}
@if($subjectClasses->count() > 0)

    <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700;
                font-size:16px; color:var(--blue-900); margin-bottom:16px;">
        📝 Students by Test Class
    </div>

    @foreach($subjectClasses as $entry)
        <div class="card" style="margin-bottom:20px;">

            {{-- Class header --}}
            <div style="display:flex; align-items:center; justify-content:space-between;
                        flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div>
                    <div style="font-family:'Plus Jakarta Sans',sans-serif; font-weight:700;
                                font-size:15px; color:var(--blue-900);">
                        {{ $entry['class']->name ?? '—' }}
                    </div>
                    <div style="font-size:12.5px; color:var(--gray-400); margin-top:3px;">
                        {{ $entry['tests']->count() }} test(s) set &nbsp;·&nbsp;
                        {{ $entry['students']->count() }} student(s) submitted
                    </div>
                </div>
                <div style="display:flex; gap:8px; flex-wrap:wrap;">
                    @foreach($entry['tests'] as $test)
                        <span class="module-badge {{ $test->is_active ? 'badge-green' : 'badge-gray' }}">
                            {{ $test->title }}
                        </span>
                    @endforeach
                </div>
            </div>

            @if($entry['students']->count() > 0)
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:13.5px;">
                        <thead>
                            <tr style="background:var(--blue-50); border-bottom:1px solid var(--gray-200);">
                                <th style="padding:11px 16px; text-align:left; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">#</th>
                                <th style="padding:11px 16px; text-align:left; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Student</th>
                                <th style="padding:11px 16px; text-align:left; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Student ID</th>
                                <th style="padding:11px 16px; text-align:center; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Tests Taken</th>
                                <th style="padding:11px 16px; text-align:center; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Avg. Score</th>
                                <th style="padding:11px 16px; text-align:left; font-weight:700;
                                           color:var(--blue-900); font-family:'Plus Jakarta Sans',sans-serif;">Last Submission</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entry['students'] as $i => $student)
                                <tr style="border-bottom:1px solid var(--gray-100); transition:background .15s;"
                                    onmouseover="this.style.background='var(--blue-50)'"
                                    onmouseout="this.style.background=''">
                                    <td style="padding:11px 16px; color:var(--gray-400); font-size:12px;">{{ $i + 1 }}</td>
                                    <td style="padding:11px 16px;">
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="width:30px; height:30px; border-radius:8px;
                                                        background:var(--blue-600); display:flex;
                                                        align-items:center; justify-content:center;
                                                        font-weight:700; font-size:11px; color:#fff;
                                                        flex-shrink:0; font-family:'Plus Jakarta Sans',sans-serif;">
                                                {{ strtoupper(substr($student->name, 0, 2)) }}
                                            </div>
                                            <span style="font-weight:600; color:var(--blue-900);">
                                                {{ $student->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding:11px 16px; color:var(--gray-500);">
                                        {{ $student->student_id }}
                                    </td>
                                    <td style="padding:11px 16px; text-align:center; font-weight:700; color:var(--blue-900);">
                                        {{ $student->tests_taken }} / {{ $student->tests_available }}
                                    </td>
                                    <td style="padding:11px 16px; text-align:center;">
                                        @if($student->avg_performance !== null)
                                            <span style="font-weight:700;
                                                color:{{ $student->avg_performance >= 75 ? 'var(--green)' : ($student->avg_performance >= 50 ? 'var(--blue-600)' : 'var(--red)') }}">
                                                {{ $student->avg_performance }}%
                                            </span>
                                        @else
                                            <span style="color:var(--gray-400); font-size:12px;">—</span>
                                        @endif
                                    </td>
                                    <td style="padding:11px 16px; color:var(--gray-400); font-size:12.5px;">
                                        {{ $student->last_submission ? $student->last_submission->diffForHumans() : '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state" style="padding:16px;">
                    <div class="empty-icon" style="font-size:24px;">📭</div>
                    <p style="font-size:13px;">No submissions yet for this class.</p>
                </div>
            @endif

        </div>
    @endforeach

@elseif(!$profile?->is_class_teacher)
    <div class="card">
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>No students yet. Students will appear here once they take your tests.</p>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function filterStudents(tableId, query) {
        const q    = query.toLowerCase();
        const rows = document.querySelectorAll(`#${tableId} .student-row`);
        rows.forEach(row => {
            const name = row.querySelector('.student-name')?.textContent.toLowerCase() ?? '';
            const id   = row.querySelector('.student-id')?.textContent.toLowerCase() ?? '';
            row.style.display = (name.includes(q) || id.includes(q)) ? '' : 'none';
        });
    }
</script>
@endpush