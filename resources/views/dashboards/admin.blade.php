<x-layout title="Admin Dashboard">
    <div style="min-height: 100vh; background: linear-gradient(135deg, #f5f7fa 0%, #f0f3f7 100%);">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; padding: 2.5rem 2rem; position: relative; overflow: hidden;">
            <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -150px; right: -150px;"></div>
            <div style="max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0 0 0.5rem 0; font-size: 2.5rem; font-weight: 800;">⚙️ Administratora Panelis</h1>
                    <p style="margin: 0; color: #BBE1FA; font-size: 1rem;">Sveiki, <strong>{{ auth()->user()->name }}</strong> — jums ir administratīvas piekļuves tiesības</p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="background: #BBE1FA; color: #0F4C75; padding: 0.75rem 1.5rem; border-radius: 10px; text-decoration: none; font-weight: 700; transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 16px rgba(187, 225, 250, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">🚪 Iziet</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">@csrf</form>
            </div>
        </div>

        <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
            <!-- Stats Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Users Card -->
                <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15); border-top: 4px solid #0F4C75; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(15, 76, 117, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(27, 38, 44, 0.15)';">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <p style="margin: 0 0 0.75rem; color: #999; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">👥 Kopējie Lietotāji</p>
                            <p style="margin: 0; font-size: 2.5rem; font-weight: 800; color: #0F4C75;">{{ \App\Models\User::count() }}</p>
                        </div>
                        <div style="font-size: 2.5rem;">👥</div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15); border-top: 4px solid #3282B8; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(50, 130, 184, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(27, 38, 44, 0.15)';">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <p style="margin: 0 0 0.75rem; color: #999; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">🎓 Skolotāji</p>
                            <p style="margin: 0; font-size: 2.5rem; font-weight: 800; color: #3282B8;">{{ \App\Models\User::where('role', 'teacher')->count() }}</p>
                        </div>
                        <div style="font-size: 2.5rem;">🎓</div>
                    </div>
                </div>

                <!-- Students Card -->
                <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15); border-top: 4px solid #BBE1FA; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 40px rgba(187, 225, 250, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(27, 38, 44, 0.15)';">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <p style="margin: 0 0 0.75rem; color: #999; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700;">📚 Studenti</p>
                            <p style="margin: 0; font-size: 2.5rem; font-weight: 800; color: #BBE1FA;">{{ \App\Models\User::where('role', 'student')->count() }}</p>
                        </div>
                        <div style="font-size: 2.5rem;">📚</div>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 10px 30px rgba(27, 38, 44, 0.15); margin-bottom: 2rem;">
                <h2 style="color: #0F4C75; margin: 0 0 1.5rem 0; font-size: 1.5rem; font-weight: 800; padding-bottom: 1rem; border-bottom: 3px solid #3282B8;">📊 Sistēmas Pārskats</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                    <!-- Subjects Overview -->
                    <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #0F4C75;">
                        <h4 style="margin: 0 0 0.75rem; color: #0F4C75; font-size: 1rem; font-weight: 700;">📖 Kursi</h4>
                        <p style="margin: 0; font-size: 2rem; font-weight: 800; color: #0F4C75;">{{ \App\Models\Subject::count() }}</p>
                        <p style="margin: 0.5rem 0 0; color: #666; font-size: 0.9rem;">Aktīvi kursi sistēmā</p>
                    </div>

                    <!-- Assignments Overview -->
                    <div style="background: linear-gradient(135deg, #f9fdf4 0%, #f0fdf4 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #4caf50;">
                        <h4 style="margin: 0 0 0.75rem; color: #2d7e2d; font-size: 1rem; font-weight: 700;">✏️ Uzdevumi</h4>
                        <p style="margin: 0; font-size: 2rem; font-weight: 800; color: #2d7e2d;">{{ \App\Models\Assignment::count() }}</p>
                        <p style="margin: 0.5rem 0 0; color: #666; font-size: 0.9rem;">Kopējie uzdevumi</p>
                    </div>

                    <!-- Submissions Overview -->
                    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fef08a 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #f59e0b;">
                        <h4 style="margin: 0 0 0.75rem; color: #8B5E00; font-size: 1rem; font-weight: 700;">📤 Iesniegtie Uzdevumi</h4>
                        <p style="margin: 0; font-size: 2rem; font-weight: 800; color: #8B5E00;">{{ \App\Models\AssignmentFile::count() }}</p>
                        <p style="margin: 0.5rem 0 0; color: #666; font-size: 0.9rem;">Kopējās iesniegšanas</p>
                    </div>
                </div>
            </div>

            <!-- Welcome Message -->
            <div style="background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); border-radius: 16px; padding: 2.5rem; color: white; box-shadow: 0 15px 40px rgba(15, 76, 117, 0.25);">
                <h3 style="margin: 0 0 1rem 0; font-size: 1.5rem; font-weight: 800;">🎯 Administratīvi Uzdevumi</h3>
                <p style="margin: 0 0 1.5rem 0; opacity: 0.95; line-height: 1.7; font-size: 1rem;">Šis administratīvais panelis ir paredzēts sistēmas uzraudzībai un pārvaldībai. Jūs varat pārraudzīt lietotājus, kursus un uzdevumus, kā arī skatīt detalizētu sistēmas aktivitāti.</p>
                <ul style="margin: 0; padding-left: 1.5rem; opacity: 0.95;">
                    <li style="margin: 0.6rem 0; line-height: 1.5;">✅ Pārraudzīt visus lietotājus un viņu lomu</li>
                    <li style="margin: 0.6rem 0; line-height: 1.5;">📊 Skatīt sistēmas aktivitātes un statistiku</li>
                    <li style="margin: 0.6rem 0; line-height: 1.5;">🎓 Pārvaldīt kursus un uzdevumus</li>
                    <li style="margin: 0.6rem 0; line-height: 1.5;">📋 Piekļūt sistēmas logiem un atskaitēm</li>
                </ul>
            </div>
        </div>
    </div>
</x-layout>
