<x-layout :title="'Assignment: ' . $assignment->title">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.05); border-radius: 50%; bottom: -100px; left: -50px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">✏️ {{ $assignment->title }}</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 0.95rem;">
                        <strong>📚 Kurss:</strong> {{ optional($assignment->subject)->name }} 
                        <span style="margin: 0 0.75rem; color: rgba(187, 225, 250, 0.5);">|</span>
                        <strong>👨‍🏫 Skolotājs:</strong> {{ optional($assignment->teacher)->name }}
                    </p>
                </div>
                <a href="{{ route('student.course.show', $assignment->subject_id) }}" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">← Atpakaļ</a>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">

            <!-- Description Section -->
            <div style="background: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📖 Apraksts & Norādījumi</h2>
                <div style="color: #1B262C; line-height: 1.8; font-size: 1rem; margin-bottom: 1.5rem;">
                    {!! nl2br(e($assignment->description)) !!}
                </div>
                <div style="background: linear-gradient(135deg, #dbeafe 0%, #e0f7eb 100%); padding: 1rem 1.5rem; border-radius: 10px; border-left: 4px solid #0F4C75;">
                    <p style="margin: 0; color: #0369a1; font-size: 0.95rem; font-weight: 600;">
                        📅 <strong>Termiņš:</strong> {{ optional($assignment->due_date)->format('d.m.Y') ?? 'Nav norādīts' }}
                        @if(optional($assignment->due_date)?->isPast())
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.3rem 0.8rem; border-radius: 6px; font-size: 0.85rem; font-weight: 600; margin-left: 0.5rem; display: inline-block;">🔴 Beidzies</span>
                        @endif
                    </p>
                </div>
            </div>

            <!-- Teacher Resources (for students) -->
            @if(!$isTeacher)
                @php $teacherFiles = $teacherFiles ?? $files->where('user_id', $assignment->teacher_id); @endphp
                @if(isset($teacherFiles) && $teacherFiles->isNotEmpty())
                    <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2rem; border-radius: 16px; margin-bottom: 2rem; box-shadow: 0 12px 36px rgba(15, 76, 117, 0.25); position: relative; overflow: hidden;">
                        <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -100px; right: -50px;"></div>
                        <h2 style="margin: 0 0 1.5rem; font-size: 1.5rem; font-weight: 800; position: relative; z-index: 1;">📚 Materiāli no Skolotāja</h2>
                        <div style="background: rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 1.5rem; backdrop-filter: blur(10px);">
                            @foreach($teacherFiles as $f)
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem 0; border-bottom: 1px solid rgba(187, 225, 250, 0.3);">
                                    <a href="{{ route('file.download', $f->id) }}" style="color: #BBE1FA; text-decoration: none; font-weight: 700; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.color='#fff'; this.style.transform='translateX(4px)';" onmouseout="this.style.color='#BBE1FA'; this.style.transform='translateX(0)';">📥 {{ $f->original_name }}</a>
                                    <span style="opacity: 0.8; font-size: 0.9rem; background: rgba(187, 225, 250, 0.2); padding: 0.3rem 0.8rem; border-radius: 6px;">{{ round($f->size/1024, 1) }} KB</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Submissions/Files Section -->
            <div style="background: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15);">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">
                    @if($isTeacher)
                        📄 Iesniegti Faili
                    @else
                        📤 Tavi Iesniegumi
                    @endif
                </h2>

                @php $studentFiles = $files; @endphp
                @if($studentFiles->isEmpty())
                    <div style="text-align: center; padding: 2.5rem 1.5rem; color: #999;">
                        <p style="font-size: 1rem; margin: 0;">
                            @if($isTeacher)
                                📭 Faili vēl nav augšuplādēti.
                            @else
                                📭 Jūs vēl neesat iesnieguši nevienu failu.
                            @endif
                        </p>
                    </div>
                @else
                    <div style="display: grid; gap: 1.2rem;">
                        @foreach($studentFiles as $f)
                            <div style="background: #f9fafb; border: 2px solid #E0E7FF; border-radius: 12px; padding: 1.5rem; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 8px 20px rgba(15, 76, 117, 0.15)';" onmouseout="this.style.borderColor='#E0E7FF'; this.style.boxShadow='0 4px 12px rgba(27, 38, 44, 0.1)';">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                                        @if($f->path)
                                            <a href="{{ route('file.download', $f->id) }}" style="color: #0F4C75; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;" onmouseover="this.style.color='#3282B8'; this.style.transform='translateX(4px)';" onmouseout="this.style.color='#0F4C75'; this.style.transform='translateX(0)';">📥 {{ $f->original_name }}</a>
                                        @else
                                            <span style="color: #0F4C75; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">📝 Tikai Piezīme</span>
                                        @endif
                                    </div>
                                    <p style="margin: 0 0 0.75rem; color: #999; font-size: 0.9rem;">
                                        ⏰ Iesūtīja: <strong>{{ optional($f->user)->name }}</strong> — {{ $f->created_at->diffForHumans() }}
                                    </p>
                                    @if($f->note)
                                        <div style="background: linear-gradient(135deg, #dbeafe 0%, #e0f7eb 100%); padding: 1rem; border-radius: 10px; border-left: 4px solid #0F4C75;">
                                            <p style="margin: 0; color: #0369a1; font-size: 0.95rem; line-height: 1.6;">{{ $f->note }}</p>
                                        </div>
                                    @endif
                                </div>
                                @if($f->path)
                                    <div style="text-align: right; color: #999; font-size: 0.9rem; min-width: 100px; margin-top: 0.75rem;">📊 {{ round($f->size/1024, 1) }} KB</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Teacher Resource Upload or Student Submission Form -->
            @if($isTeacher)
                <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 12px 36px rgba(15, 76, 117, 0.25); position: relative; overflow: hidden;">
                    <div style="position: absolute; width: 200px; height: 200px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -100px; right: -50px;"></div>
                    <h2 style="margin: 0 0 1.5rem; font-size: 1.5rem; font-weight: 800; position: relative; z-index: 1;">📚 Pievienot Materiālus Studentiem</h2>
                    <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data" style="display: flex; gap: 1rem; flex-wrap: wrap; position: relative; z-index: 1;">
                        @csrf
                        <div style="flex: 1; min-width: 200px;">
                            <label style="color: white; display: block; margin-bottom: 0.75rem; font-weight: 700; letter-spacing: 0.5px;">Izvēlieties Failu</label>
                            <input type="file" name="file" required style="background: white; color: #1B262C; border: none; padding: 0.9rem; border-radius: 8px; width: 100%; font-weight: 600; cursor: pointer;">
                        </div>
                        <div style="display: flex; align-items: flex-end;">
                            <button type="submit" style="background: white; color: #0F4C75; padding: 0.9rem 2rem; border-radius: 8px; border: none; font-weight: 700; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.2)';">📤 Augšuplādēt</button>
                        </div>
                    </form>
                </div>
            @else
                <div style="background: white; border-radius: 16px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15); margin-bottom: 1.5rem;">
                    <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📤 Iesniegt Savu Darbu</h2>
                    <form method="POST" action="{{ route('assignment.upload', $assignment->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div style="display: grid; gap: 1.5rem;">
                            <div>
                                <label style="display: block; margin-bottom: 0.75rem; font-weight: 700; color: #1B262C; letter-spacing: 0.5px;">📎 Fails (Nav Obligāti)</label>
                                <input type="file" name="file" style="padding: 0.9rem; border: 2px solid #E0E7FF; border-radius: 8px; width: 100%; color: #1B262C; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 4px 12px rgba(15, 76, 117, 0.1)';" onmouseout="this.style.borderColor='#E0E7FF'; this.style.boxShadow='none';">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 0.75rem; font-weight: 700; color: #1B262C; letter-spacing: 0.5px;">💬 Piezīme Skolotājam (Nav Obligāti)</label>
                                <textarea name="note" style="padding: 0.9rem; border: 2px solid #E0E7FF; border-radius: 8px; width: 100%; font-family: inherit; font-size: 1rem; min-height: 100px; color: #1B262C; resize: vertical; transition: all 0.3s ease;" placeholder="Rakstiet jebkādas piezīmes vai komentārus savam skolotājam..." onmouseover="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 4px 12px rgba(15, 76, 117, 0.1)';" onmouseout="this.style.borderColor='#E0E7FF'; this.style.boxShadow='none';"></textarea>
                            </div>
                            <div>
                                <button type="submit" style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 1rem 2rem; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: all 0.3s ease; font-size: 1rem; box-shadow: 0 6px 16px rgba(15, 76, 117, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(15, 76, 117, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 16px rgba(15, 76, 117, 0.3)';">📤 Iesniegt</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Messages -->
                @if($errors->any())
                    <div style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border-left: 4px solid #dc2626; padding: 1.25rem; border-radius: 10px; color: #991b1b; box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);">
                        <p style="margin: 0; font-weight: 700; font-size: 1rem;">❌ Kļūda:</p>
                        <p style="margin: 0.5rem 0 0; font-size: 0.95rem;">{{ $errors->first() }}</p>
                    </div>
                @endif
                @if(session('success'))
                    <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-left: 4px solid #059669; padding: 1.25rem; border-radius: 10px; color: #065f46; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.15);">
                        <p style="margin: 0; font-weight: 700; font-size: 1rem;">✅ Veiksmīgi!</p>
                        <p style="margin: 0.5rem 0 0; font-size: 0.95rem;">{{ session('success') }}</p>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layout>
