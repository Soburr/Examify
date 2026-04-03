@if(isset($performance) && count($performance) > 0)
    <div class="perf-row">
        @foreach($performance as $subject => $pct)
            <div class="perf-item">
                <div class="perf-top">
                    <span class="perf-subj">{{ $subject }}</span>
                    <span class="perf-pct">{{ $pct }}%</span>
                </div>
                <div class="perf-track">
                    <div class="perf-fill {{ $pct >= 75 ? 'high' : ($pct >= 50 ? 'medium' : 'low') }}"
                         style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
@else
    {{-- Demo / placeholder data --}}
    <div class="perf-row">
        @foreach(['Mathematics' => 70, 'Physics' => 80, 'English' => 65, 'Chemistry' => 45, 'Biology' => 88] as $subject => $pct)
            <div class="perf-item">
                <div class="perf-top">
                    <span class="perf-subj">{{ $subject }}</span>
                    <span class="perf-pct">{{ $pct }}%</span>
                </div>
                <div class="perf-track">
                    <div class="perf-fill {{ $pct >= 75 ? 'high' : ($pct >= 50 ? 'medium' : 'low') }}"
                         style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
@endif