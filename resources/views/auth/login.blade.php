<x-layout title="Login">
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); position: relative; overflow: hidden; padding: 2rem;">
        <!-- Decorative Background -->
        <div style="position: absolute; width: 400px; height: 400px; background: rgba(187, 225, 250, 0.1); border-radius: 50%; top: -200px; right: -200px;"></div>
        <div style="position: absolute; width: 300px; height: 300px; background: rgba(187, 225, 250, 0.05); border-radius: 50%; bottom: -150px; left: -150px;"></div>

        <div style="width: 100%; max-width: 450px; position: relative; z-index: 1;">
            <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 20px 60px rgba(27, 38, 44, 0.3);">
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 2.5rem;">
                    <h1 style="color: #0F4C75; margin: 0 0 0.5rem 0; font-size: 2rem; font-weight: 800;">Pieslēgties</h1>
                    <p style="color: #999; margin: 0; font-size: 0.95rem;">Ievadiet savus akreditācijas datus</p>
                </div>

                <!-- Errors -->
                @if ($errors->any())
                    <div style="background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); border-left: 4px solid #f44336; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem; color: #c62828;">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li style="margin: 0.25rem 0;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.6rem; font-weight: 600; color: #1B262C;">📧 E-Pasts</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               style="width: 100%; padding: 0.9rem 1rem; border: 2px solid #E0E7FF; border-radius: 10px; color: #1B262C; font-size: 1rem; transition: all 0.3s ease;"
                               onfocus="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 0 0 4px rgba(15, 76, 117, 0.1)';"
                               onblur="this.style.borderColor='#E0E7FF'; this.style.boxShadow='none';">
                    </div>

                    <!-- Password Field -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.6rem; font-weight: 600; color: #1B262C;">🔐 Parole</label>
                        <input type="password" name="password" required
                               style="width: 100%; padding: 0.9rem 1rem; border: 2px solid #E0E7FF; border-radius: 10px; color: #1B262C; font-size: 1rem; transition: all 0.3s ease;"
                               onfocus="this.style.borderColor='#0F4C75'; this.style.boxShadow='0 0 0 4px rgba(15, 76, 117, 0.1)';"
                               onblur="this.style.borderColor='#E0E7FF'; this.style.boxShadow='none';">
                    </div>

                    <!-- Remember Me -->
                    <div style="display: flex; align-items: center; margin-bottom: 2rem;">
                        <input type="checkbox" name="remember" id="remember" style="width: 18px; height: 18px; margin-right: 0.6rem; cursor: pointer; accent-color: #0F4C75;">
                        <label for="remember" style="margin: 0; cursor: pointer; font-weight: 500; color: #555;">Atcerēties mani</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" style="width: 100%; padding: 1rem; background: linear-gradient(135deg, #0F4C75 0%, #3282B8 100%); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 1rem; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(15, 76, 117, 0.3);"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 28px rgba(15, 76, 117, 0.4)';"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(15, 76, 117, 0.3)';">
                        🔐 Pieslēgties
                    </button>

                    <!-- Sign Up Link -->
                    <div style="text-align: center; margin-top: 1.5rem; color: #999; font-size: 0.95rem;">
                        Nav uztaisīts konts? 
                        <a href="{{ route('register.show') }}" style="color: #0F4C75; text-decoration: none; font-weight: 700; transition: color 0.3s ease;"
                           onmouseover="this.style.color='#3282B8';"
                           onmouseout="this.style.color='#0F4C75';">
                            Reģistrēties
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
