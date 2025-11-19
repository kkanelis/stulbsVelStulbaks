<x-layout title="Welcome">
    <div class="welcome-container">
        <h1>Sveicināti uz Classroom</h1>
        <br>
        <div class="buttons">
            <a href="{{ route('register.show') }}" class="btn btn-primary">Reģistrēties</a>
            <a href="{{ route('login.show') }}" class="btn btn-ghost">Ieet Profilā</a>
        </div>
    </div>
</x-layout>
