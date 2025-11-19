<x-layout title="Register">
    <div class="auth-container">
        <h1>Reģistrēties</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="auth-field">
                <label>Vārds</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="auth-field">
                <label>E-Pasts</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="auth-field">
                <label>Parole</label>
                <input type="password" name="password" required>
            </div>

            <div class="auth-field">
                <label>Apstiprināt Paroli</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div class="auth-field">
                <label>Loma</label>
                <select name="role">
                    <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Pupils / Student</option>
                    <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
            </div>

            <div class="auth-field">
                <label>Admin code (optional)</label>
                <input type="text" name="admin_code" value="{{ old('admin_code') }}" placeholder="leave empty unless you have admin code">
            </div>

            <div class="auth-actions">
                <div class="small link-muted">Ir jau konts? <a href="{{ route('login.show') }}">Pieslēgties</a></div>
                <button class="btn" type="submit">Reģistrēties</button>
            </div>
        </form>
    </div>
</x-layout>
