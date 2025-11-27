<x-layout title="Welcome - Classroom">
    <!-- Hero Section -->
    <div style="min-height: 100vh; background: linear-gradient(135deg, #0F4C75 0%, #3282B8 50%, #1B262C 100%); display: flex; align-items: center; justify-content: center; padding: 2rem; position: relative; overflow: hidden;">
        <!-- Decorative Elements -->
        <div style="position: absolute; width: 500px; height: 500px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -250px; right: -250px;"></div>
        <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.05); border-radius: 50%; bottom: -150px; left: -150px;"></div>

        <div style="max-width: 900px; width: 100%; text-align: center; color: white; position: relative; z-index: 1;">
            <!-- Main Title -->
            <div style="margin-bottom: 3rem;">
                <h1 style="font-size: 4.5rem; margin: 0 0 1rem 0; font-weight: 800; letter-spacing: -1px;">
                    Classroom
                </h1>
                <p style="font-size: 1.5rem; margin: 0; color: #BBE1FA; font-weight: 300; letter-spacing: 0.5px;">
                    Modernā izglītības vadības platforma
                </p>
            </div>

            <!-- Description -->
            <p style="font-size: 1.1rem; color: rgba(187, 225, 250, 0.95); line-height: 1.8; margin-bottom: 3rem; max-width: 600px; margin-left: auto; margin-right: auto;">
                Pievienojies revolucionārai izglītības videi, kur skolotāji un studenti var efektīvi sadarbībā mācīties, mācīt un augt kopā.
            </p>

            <!-- Buttons -->
            <div style="display: flex; gap: 1.5rem; flex-direction: column; max-width: 400px; margin: 0 auto 3rem;">
                <a href="{{ route('register.show') }}" style="background: #BBE1FA; color: #0F4C75; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.1rem; transition: all 0.3s ease; display: inline-block; box-shadow: 0 8px 24px rgba(187, 225, 250, 0.3);"
                   onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 32px rgba(187, 225, 250, 0.4)';"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(187, 225, 250, 0.3)';">
                    ✨ Reģistrēties
                </a>
                <a href="{{ route('login.show') }}" style="background: transparent; color: #BBE1FA; padding: 1.2rem 2.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 1.1rem; transition: all 0.3s ease; display: inline-block; border: 2px solid #BBE1FA;"
                   onmouseover="this.style.background='rgba(187, 225, 250, 0.1)';"
                   onmouseout="this.style.background='transparent';">
                    🔐 Ieet Profilā
                </a>
            </div>

            <!-- Features Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem;">
                <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 16px; border: 1px solid rgba(187, 225, 250, 0.2); transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(-5px)';"
                     onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)';">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📚</div>
                    <h3 style="color: #BBE1FA; margin: 0.75rem 0; font-size: 1.3rem;">Dinamiski Kursi</h3>
                    <p style="font-size: 0.95rem; color: rgba(187, 225, 250, 0.85); margin: 0;">Pilnībā vadīti un pārvaldīti kursi ar reāllaikā atjauninājumiem</p>
                </div>
                <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 16px; border: 1px solid rgba(187, 225, 250, 0.2); transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(-5px)';"
                     onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)';">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">✍️</div>
                    <h3 style="color: #BBE1FA; margin: 0.75rem 0; font-size: 1.3rem;">Intelektuālie Uzdevumi</h3>
                    <p style="font-size: 0.95rem; color: rgba(187, 225, 250, 0.85); margin: 0;">Pārvaldiet, iesniedz un sekojiet uzdevuma progresam</p>
                </div>
                <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(10px); padding: 2rem; border-radius: 16px; border: 1px solid rgba(187, 225, 250, 0.2); transition: all 0.3s ease;"
                     onmouseover="this.style.background='rgba(255, 255, 255, 0.15)'; this.style.transform='translateY(-5px)';"
                     onmouseout="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.transform='translateY(0)';">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📊</div>
                    <h3 style="color: #BBE1FA; margin: 0.75rem 0; font-size: 1.3rem;">Viedo Atzīmes</h3>
                    <p style="font-size: 0.95rem; color: rgba(187, 225, 250, 0.85); margin: 0;">Sekojiet progresam, analizējiet sasniegumus un augstējies</p>
                </div>
            </div>
        </div>
    </div>
</x-layout>
