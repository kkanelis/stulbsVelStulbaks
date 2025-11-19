<x-layout title="Login">
    <div class="auth-container">
        <h1>Pieslēgties</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="auth-field">
                <label>E-Pasts</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="auth-field">
                <label>Parole</label>
                <input type="password" name="password" required>
            </div>

            <div class="auth-field">
                <label>
                    <input type="checkbox" name="remember"> Atcerēties mani
                </label>
            </div>

            <div class="auth-actions">
                <div class="small link-muted">Nav uztaisīts konts? <a href="{{ route('register.show') }}">Reģistrēties</a></div>
                <button class="btn" type="submit">Pieslēgties</button>
            </div>
        </form>
    </div>
</x-layout>
