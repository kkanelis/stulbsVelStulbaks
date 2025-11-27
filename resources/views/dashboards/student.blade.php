<x-layout title="Student Dashboard">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">📚 Studentu Panelis</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 1rem;">Sveiki atpakaļ, <strong>{{ auth()->user()->name }}</strong></p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">🚪 Iziet</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Join Course Section -->
            <div style="background: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">✨ Pievienojieties Kursam</h2>
                <form method="POST" action="{{ route('student.join') }}" style="display: flex; gap: 1rem; align-items: flex-end;">
                    @csrf
                    <div style="flex: 1; min-width: 250px;">
                        <label style="color: #1B262C; font-weight: 700; display: block; margin-bottom: 0.6rem; font-size: 0.95rem;">🔑 Kursa Kods (6 burti)</label>
                        <input type="text" name="code" placeholder="Piemēram: ABC123" maxlength="6" style="text-transform: uppercase; width: 100%; padding: 0.9rem 1rem; background: white; color: #1B262C; border: 2px solid #E0E7FF; border-radius: 10px; font-weight: 600; transition: all 0.3s ease;" onfocus="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 0 0 4px rgba(15, 76, 117, 0.1)';" onblur="this.style.borderColor='#E0E7FF'; this.style.boxShadow='none';" required>
                    </div>
                    <button type="submit" style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 0.9rem 2rem; border-radius: 10px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 16px rgba(15, 76, 117, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(15, 76, 117, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 16px rgba(15, 76, 117, 0.3)';">✅ Pievienojies</button>
                </form>
                @if ($errors->has('code'))
                    <div style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left: 4px solid #f44336; padding: 1rem; border-radius: 10px; margin-top: 1rem; color: #c62828; font-weight: 600;">
                        ❌ {{ $errors->first('code') }}
                    </div>
                @endif
                @if (session('success'))
                    <div style="background: linear-gradient(135deg, #e8f5e9 0%, #d4edda 100%); border-left: 4px solid #4caf50; padding: 1rem; border-radius: 10px; margin-top: 1rem; color: #2e7d32; font-weight: 600;">
                        ✅ {{ session('success') }}
                    </div>
                @endif
            </div>

            <!-- My Courses Section -->
            <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📖 Mani Kursi</h2>
                @php $subjects = auth()->user()->enrolledSubjects()->withCount(['students'])->get(); @endphp
                @if($subjects->isEmpty())
                    <div style="text-align: center; padding: 3rem 1.5rem; color: #999;">
                        <p style="font-size: 1.1rem; margin: 0;">📚 Jūs vēl neesat reģistrējies nevienā kursā.</p>
                        <p style="margin: 0.5rem 0 0; font-size: 0.95rem;">Izmantojiet formu iepriekš vai lūdziet skolotājam 6 burtu kodu</p>
                    </div>
                @else
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                        @foreach($subjects as $subject)
                            <a href="{{ route('student.course.show', $subject->id) }}" style="text-decoration: none; color: inherit;">
                                <div style="background: linear-gradient(135deg, #f9fafb 0%, #f5f7fa 100%); border: 2px solid #E0E7FF; border-radius: 14px; padding: 1.5rem; height: 100%; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='#0F4C75'; this.style.transform='translateY(-5px)'; this.style.boxShadow='0 12px 32px rgba(15, 76, 117, 0.2)';" onmouseout="this.style.borderColor='#E0E7FF'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(27, 38, 44, 0.1)';">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                        <h3 style="margin: 0; color: #0F4C75; font-size: 1.25rem; font-weight: 800;">{{ $subject->name }}</h3>
                                        <span style="background: linear-gradient(135deg, #BBE1FA 0%, #E0E7FF 100%); color: #0F4C75; padding: 0.4rem 0.8rem; border-radius: 8px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">{{ $subject->code }}</span>
                                    </div>
                                    <p style="margin: 0.75rem 0; color: #666; font-size: 0.95rem;">
                                        <strong>👨‍🏫 Skolotājs:</strong> {{ optional($subject->teacher)->name ?? '—' }}
                                    </p>
                                    <p style="margin: 0.75rem 0 0; color: #999; font-size: 0.9rem; padding-top: 1rem; border-top: 1px solid #E0E7FF;">
                                        👥 {{ $subject->students_count }} studenti
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
