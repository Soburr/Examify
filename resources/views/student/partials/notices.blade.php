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
    <div class="notice-list">
        <div class="notice-item">
            <div class="notice-dot" style="background:var(--red)"></div>
            <div>
                <div class="notice-text"><strong>Upcoming Test</strong> – Mathematics test scheduled for next Monday.</div>
                <div class="notice-meta">2 hours ago</div>
            </div>
        </div>
        <div class="notice-item">
            <div class="notice-dot" style="background:var(--amber)"></div>
            <div>
                <div class="notice-text"><strong>New Material</strong> – Physics notes for Chapter 6 have been uploaded.</div>
                <div class="notice-meta">Yesterday</div>
            </div>
        </div>
        <div class="notice-item">
            <div class="notice-dot" style="background:var(--green)"></div>
            <div>
                <div class="notice-text"><strong>Result Published</strong> – English test results are now available.</div>
                <div class="notice-meta">2 days ago</div>
            </div>
        </div>
    </div>
@endif