<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">🎓</div>
        <div class="brand-text">
            JGSGS
            <span>Teacher Dashboard</span>
        </div>
    </div>

    <div class="nav-section">
        <div class="nav-label">Main</div>

        <a href="{{ route('teacher.dashboard') }}"
           class="nav-item {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">🏠</span> Dashboard
        </a>

        <a href="{{ route('teacher.exams.index') }}"
           class="nav-item {{ request()->routeIs('teacher.exams.*') ? 'active' : '' }}">
            <span class="nav-icon">📝</span> Create a Test
        </a>

        <a href="{{ route('student.results') }}"
           class="nav-item {{ request()->routeIs('student.results') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> View Results
        </a>

        <a href="{{ route('student.materials') }}"
           class="nav-item {{ request()->routeIs('student.materials') ? 'active' : '' }}">
            <span class="nav-icon">📁</span> Study Materials
        </a>

        <a href="{{ route('student.performance') }}"
           class="nav-item {{ request()->routeIs('student.performance') ? 'active' : '' }}">
            <span class="nav-icon">📈</span> Performance
        </a>
    </div>

    <div class="nav-section">
        <div class="nav-label">Account</div>

        <a href="{{ route('student.profile') }}"
           class="nav-item {{ request()->routeIs('student.profile') ? 'active' : '' }}">
            <span class="nav-icon">👤</span> My Profile
        </a>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('student.logout') }}">
            @csrf
            <button class="logout-btn" type="submit">
                <span>🚪</span> Logout
            </button>
        </form>
    </div>
</aside>