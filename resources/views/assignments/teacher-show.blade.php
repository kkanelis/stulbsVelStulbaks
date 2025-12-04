<x-layout :title="'Assignment: ' . $assignment->title . ' (Teacher View)'">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.05); border-radius: 50%; bottom: -100px; left: -50px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">✏️ {{ $assignment->title }}</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 0.95rem;">
                        <strong>📚 Kurss:</strong> {{ optional($subject)->name }} 
                        <span style="margin: 0 0.75rem; color: rgba(187, 225, 250, 0.5);">|</span>
                        <strong>📅 Termiņš:</strong> {{ optional($assignment->due_date)->format('d.m.Y') }}
                    </p>
                </div>
                <a href="{{ url()->previous() }}" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">← Atpakaļ</a>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">

            <!-- Description Section -->
            <div style="background: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📖 Uzdevuma Apraksts</h2>
                <div style="color: #1B262C; line-height: 1.8; font-size: 1rem;">
                    {!! nl2br(e($assignment->description)) !!}
                </div>
            </div>

            <!-- Teacher Resources Section -->
            <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); padding: 2.5rem; border-radius: 16px; margin-bottom: 2rem; color: white; box-shadow: 0 12px 36px rgba(15, 76, 117, 0.25); position: relative; overflow: hidden;">
                <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -100px; right: -50px;"></div>
                <h2 style="margin: 0 0 1.5rem; font-size: 1.5rem; color: white; font-weight: 800; position: relative; z-index: 1;">📚 Materiāli Studentiem</h2>
                
                @php $teacherFiles = $files->where('user_id', auth()->id()); @endphp
                
                @if($teacherFiles->isEmpty())
                    <p style="margin: 0 0 1.5rem; opacity: 0.95; position: relative; z-index: 1;">📭 Resursi vēl nav augšuplādēti.</p>
                @else
                    <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem; backdrop-filter: blur(10px); position: relative; z-index: 1;">
                        @foreach($teacherFiles as $f)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.9rem 0; border-bottom: 1px solid rgba(187, 225, 250, 0.3);">
                                <a href="{{ route('file.download', $f->id) }}" style="color: #BBE1FA; text-decoration: none; font-weight: 700; flex: 1; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='#fff'; this.style.transform='translateX(4px)';" onmouseout="this.style.color='#BBE1FA'; this.style.transform='translateX(0)';">
                                    📥 {{ $f->original_name }}
                                </a>
                                <span style="opacity: 0.8; font-size: 0.9rem; background: rgba(187, 225, 250, 0.2); padding: 0.3rem 0.8rem; border-radius: 6px;">{{ round($f->size/1024, 1) }} KB</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data" style="padding-top: 1.5rem; border-top: 1px solid rgba(187, 225, 250, 0.3); position: relative; z-index: 1;">
                    @csrf
                    <div style="display: flex; gap: 1rem; align-items: flex-end; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 200px;">
                            <label style="color: white; display: block; margin-bottom: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">📎 Jauns Resurss</label>
                            <input type="file" name="file" required style="background: white; color: #1B262C; border: none; padding: 0.9rem; border-radius: 8px; width: 100%; font-weight: 600; cursor: pointer;">
                        </div>
                        <button type="submit" style="background: white; color: #0F4C75; padding: 0.9rem 2rem; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.2)';">📤 Augšuplādēt</button>
                    </div>
                </form>
            </div>

            <!-- Student Submissions Section -->
            <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📋 Studentu Iesniegumi & Vērtējumi</h2>

                @if($students->isEmpty())
                    <div style="text-align: center; padding: 2.5rem 1.5rem; color: #999;">
                        <p style="font-size: 1rem; margin: 0;">📭 Šajā kursā nav reģistrēti studenti.</p>
                    </div>
                @else
                    <div style="display: grid; gap: 1.5rem;">
                        @foreach($students as $student)
                            @php $submissions = $files->where('user_id', $student->id); $grade = $student->grades->first(); @endphp
                            <div style="background: #f9fafb; border: 2px solid #E0E7FF; border-radius: 12px; padding: 1.75rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 8px 20px rgba(15, 76, 117, 0.15)';" onmouseout="this.style.borderColor='#E0E7FF'; this.style.boxShadow='0 4px 12px rgba(27, 38, 44, 0.1)';">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                    <div>
                                        <h4 style="margin: 0 0 0.25rem; color: #0F4C75; font-size: 1.1rem; font-weight: 700;">👤 {{ $student->name }}</h4>
                                        <p style="margin: 0; color: #666; font-size: 0.9rem;">✉️ {{ $student->email }}</p>
                                    </div>
                                    <div style="text-align: right;">
                                        @if($grade)
                                            <span style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #065f46; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);">✓ Vērtējums: {{ $grade->grade }}/100</span>
                                        @else
                                            <span style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #8B5E00; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 700; display: inline-block; box-shadow: 0 4px 12px rgba(217, 119, 6, 0.15);">⏳ Nav Vērtēts</span>
                                        @endif
                                    </div>
                                </div>

                                @if($submissions->isEmpty())
                                    <p style="margin: 0; color: #999; font-size: 0.9rem;">📭 Vēl nav iesnieguši.</p>
                                @else
                                    <div style="background: white; padding: 1.2rem; border-radius: 10px; border-left: 4px solid #0F4C75;">
                                        <p style="margin: 0 0 0.75rem; color: #0F4C75; font-weight: 700; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">📋 Iesniegumi:</p>
                                        @foreach($submissions as $sub)
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.6rem 0; border-bottom: 1px solid #E0E7FF;">
                                                <a href="{{ route('file.download', $sub->id) }}" style="color: #0F4C75; text-decoration: none; font-weight: 600; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='#3282B8'; this.style.transform='translateX(4px)';" onmouseout="this.style.color='#0F4C75'; this.style.transform='translateX(0)';">📥 {{ $sub->original_name }}</a>
                                                <span style="color: #999; font-size: 0.85rem;">⏰ {{ $sub->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($sub->note)
                                                <div style="background: linear-gradient(135deg, #dbeafe 0%, #e0f7eb 100%); padding: 0.9rem; border-radius: 8px; margin-top: 0.6rem; color: #0369a1; font-size: 0.9rem; border-left: 3px solid #0F4C75;">
                                                    <strong>💬 Piezīme:</strong> {{ $sub->note }}
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        {{-- Grade form and feedback (Latvian) --}}
                                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px dashed #E6EEF9; display: grid; gap: 0.75rem;">
                                            @if($grade && $grade->feedback)
                                                <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e6f6ff 100%); padding: 0.9rem; border-radius: 8px; color: #0F4C75;">
                                                    <strong>Atsauksme no iepriekš:</strong>
                                                    <p style="margin: 0.5rem 0 0 0;">{{ $grade->feedback }}</p>
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('teacher.gradeAssignment', $assignment->id) }}" style="display: grid; gap: 0.5rem; grid-template-columns: 1fr auto; align-items: end;">
                                                @csrf
                                                <input type="hidden" name="student_id" value="{{ $student->id }}">

                                                <div style="display: grid; gap: 0.5rem;">
                                                    <label style="font-weight:700; color:#1B262C;">Vērtējums (0-100)</label>
                                                    <input name="grade" type="number" min="0" max="100" step="0.1" value="{{ $grade?->grade ?? '' }}" style="padding:0.6rem; border:2px solid #E0E7FF; border-radius:8px; width:100%;">

                                                    <label style="font-weight:700; color:#1B262C;">Atsauksme</label>
                                                    <textarea name="feedback" rows="3" style="padding:0.6rem; border:2px solid #E0E7FF; border-radius:8px; width:100%;">{{ $grade?->feedback ?? '' }}</textarea>
                                                </div>

                                                <div>
                                                    <button type="submit" style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 0.75rem 1rem; border-radius: 8px; border:none; font-weight:700; cursor:pointer;">Saglabāt vērtējumu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
