<a href="{{ route('student.assignments.show', [$assignment->classroom_id, $assignment]) }}"
    class="block bg-white border border-gray-200 rounded-xl p-4 hover:border-indigo-300 hover:shadow-sm transition">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center
                @if($assignment->submissions->isEmpty())
                    bg-orange-100
                @elseif($assignment->submissions->first()->status === 'graded')
                    bg-green-100
                @else
                    bg-blue-100
                @endif">
                <svg class="w-6 h-6 
                    @if($assignment->submissions->isEmpty())
                        text-orange-600
                    @elseif($assignment->submissions->first()->status === 'graded')
                        text-green-600
                    @else
                        text-blue-600
                    @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $assignment->title }}</h3>
                <p class="text-sm text-gray-500">{{ $assignment->classroom->name ?? 'Kelas' }}</p>
            </div>
        </div>
        <div class="text-right">
            @if($assignment->submissions->isEmpty())
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                    Belum Dikerjakan
                </span>
            @elseif($assignment->submissions->first()->status === 'graded')
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                    Nilai: {{ $assignment->submissions->first()->score }}/{{ $assignment->max_score }}
                </span>
            @else
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                    Dikumpulkan
                </span>
            @endif
            @if($assignment->due_date)
                <p class="text-xs text-gray-400 mt-1">
                    Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}
                </p>
            @endif
        </div>
    </div>
</a>