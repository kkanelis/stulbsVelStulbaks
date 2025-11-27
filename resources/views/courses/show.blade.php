<x-layout :title="'Course: ' . $subject->name">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.05); border-radius: 50%; bottom: -100px; left: -50px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">📖 {{ $subject->name }}</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 0.95rem;">
                        <strong>👨‍🏫 Skolotājs:</strong> {{ optional($subject->teacher)->name ?? '—' }} 
                        <span style="margin: 0 0.75rem; color: rgba(187, 225, 250, 0.5);">|</span>
                        <strong>🔐 Kursa Kods:</strong> <span style="letter-spacing: 1px; background: rgba(187, 225, 250, 0.2); padding: 0.3rem 0.9rem; border-radius: 6px; display: inline-block; font-family: 'Courier New', monospace;">{{ $subject->code }}</span>
                    </p>
                </div>
                <a href="{{ route('dashboard.student') }}" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">← Atpakaļ</a>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Assignments Section -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">✏️ Uzdevumi</h2>

                @if($assignments->isEmpty())
                    <div style="text-align: center; padding: 3rem 1.5rem; color: #999;">
                        <p style="font-size: 1.1rem;">📭 Šim kursam vēl nav neviena uzdevuma.</p>
                    </div>
                @else
                    <div style="display: grid; gap: 1.2rem;">
                        @foreach($assignments as $assignment)
                            <a href="{{ route('assignment.show', $assignment->id) }}" style="text-decoration: none; color: inherit;">
                                <div style="background: white; border: 2px solid #E0E7FF; border-radius: 12px; padding: 1.75rem; transition: all 0.3s ease; display: flex; gap: 1.5rem; align-items: center; cursor: pointer;"
                                     onmouseover="this.style.borderColor='#0F4C75'; this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 28px rgba(15, 76, 117, 0.2)';"
                                     onmouseout="this.style.borderColor='#E0E7FF'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(27, 38, 44, 0.1)';">
                                    <div style="font-size: 2.5rem;">✏️</div>
                                    <div style="flex: 1;">
                                        <h4 style="margin: 0 0 0.5rem; color: #0F4C75; font-size: 1.15rem; font-weight: 700;">{{ $assignment->title }}</h4>
                                        <p style="margin: 0.25rem 0; color: #666; font-size: 0.9rem;">
                                            📅 <strong>Termiņš:</strong> {{ optional($assignment->due_date)->format('d.m.Y') ?? 'Nav norādīts' }}
                                        </p>
                                        <div style="margin-top: 0.5rem;">
                                            @if(optional($assignment->due_date)->isPast())
                                                <span style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: inline-block;">🔴 Pārraidīts</span>
                                            @elseif(optional($assignment->due_date)?->diffInDays(now()) <= 1)
                                                <span style="background: #fef3c7; color: #8B5E00; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: inline-block;">⚠️ Drīz Beigsies</span>
                                            @else
                                                <span style="background: #dbeafe; color: #0369a1; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600; display: inline-block;">✅ Aktīvs</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="text-align: right;">
                                        @php $grade = $assignment->grades->first(); @endphp
                                        @if($grade)
                                            <span style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">✓ Vērtējums: {{ $grade->grade }}</span>
                                        @else
                                            <span style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #8B5E00; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);">⏳ Gaida Vērtējumu</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
