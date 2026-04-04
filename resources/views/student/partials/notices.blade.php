@if(isset($notices) && count($notices) > 0)
    <div class="notice-list">
        @foreach($notices as $notice)
            <div class="notice-item">
                <div class="notice-dot" style="background:var(--blue-500)"></div>
                <div>
                    <div class="notice-text">{{ $notice->content }}</div>
                    <div class="notice-meta">{{ $notice->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="notice-empty">
        <div class="notice-icon">📭</div>
        <div class="notice-message">No new notices at the moment.</div>
    </div>
@endif