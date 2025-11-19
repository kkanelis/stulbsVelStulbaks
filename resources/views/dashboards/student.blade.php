<x-layout title="Student Dashboard">
    <div class="welcome-container">
        <h1>Student Dashboard</h1>
        <p class="subtitle">Hello, {{ auth()->user()->name }} — welcome to your dashboard.</p>
        <p><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></p>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
    </div>
</x-layout>
