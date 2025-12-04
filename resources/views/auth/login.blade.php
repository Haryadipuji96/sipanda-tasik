<x-guest-layout>
    <!-- Logo -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo SIPANDA" class="mx-auto w-24 h-24">
    </div>

    <!-- Heading dengan style baru -->
    <div class="heading-container">
        <div class="heading-main">
            <span class="heading-text">LOGIN</span>
            <span class="heading-glow"></span>
        </div>
        <div class="heading-subtitle">
            <span class="subtitle-text">SIPANDA SYSTEM</span>
            <div class="subtitle-line"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="form">
        <!-- ... (form yang sama seperti sebelumnya) ... -->
        @csrf

        <!-- Email -->
        <input required class="input" type="email" name="email" id="email" placeholder="E-mail"
            :value="old('email')" autofocus>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />

        <!-- Password dengan icon mata -->
        <div class="password-wrapper">
            <input required class="input password-input" type="password" name="password" id="password" placeholder="Password">
            <button type="button" class="toggle-password" id="togglePassword">
                <svg class="eye-icon eye-open" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
                <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            </button>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <!-- Remember Me & Forgot Password -->
        <div class="flex justify-between mt-2 items-center text-sm text-gray-600">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="underline text-blue-600 hover:text-blue-800">Forgot
                    Password?</a>
            @endif
        </div>

        <!-- Submit Button -->
        <input class="login-button mt-6" type="submit" value="Login SIPANDA">
    </form>

    <!-- Info Box untuk yang belum punya akun -->
    <div class="info-box">
        <div class="info-icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div class="info-content">
            <h3 class="info-title">Belum punya akun?</h3>
            <p class="info-text">
                Sistem login ini khusus untuk pengguna terdaftar. Jika Anda belum memiliki akun,
                silakan hubungi <strong>Superadmin</strong> untuk membuatkan akun baru.
            </p>
            <div class="info-contact">
                <div class="contact-item">
                    <svg xmlns="http://www.w3.org2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>Hubungi Superadmin</span>
                </div>
                <div class="contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>superadmin@iaitasik.ac.id</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* RESET - Hapus semua background dan container */
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f7fa 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }

        /* Efek background tambahan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(14, 165, 233, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(37, 99, 235, 0.1) 0%, transparent 50%);
            z-index: -1;
        }

        /* Logo */
        .text-center.mb-4 {
            margin-bottom: 1.5rem;
        }

        .text-center.mb-4 img {
            filter: drop-shadow(0 4px 12px rgba(14, 165, 233, 0.2));
            transition: transform 0.3s ease;
        }

        .text-center.mb-4 img:hover {
            transform: scale(1.05);
        }

        /* HEADING CONTAINER - STYLE BARU */
        .heading-container {
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .heading-main {
            position: relative;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .heading-text {
            font-size: 2.8rem;
            font-weight: 800;
            color: #0ea5e9;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 2;
            text-shadow: 
                0 2px 4px rgba(14, 165, 233, 0.2),
                0 4px 8px rgba(14, 165, 233, 0.1);
            animation: textGlow 2s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% {
                text-shadow: 
                    0 2px 4px rgba(14, 165, 233, 0.2),
                    0 4px 8px rgba(14, 165, 233, 0.1);
            }
            100% {
                text-shadow: 
                    0 2px 8px rgba(14, 165, 233, 0.3),
                    0 6px 20px rgba(14, 165, 233, 0.2),
                    0 0 30px rgba(14, 165, 233, 0.1);
            }
        }

        .heading-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 1;
            filter: blur(15px);
            animation: glowPulse 3s ease-in-out infinite alternate;
        }

        @keyframes glowPulse {
            0% {
                opacity: 0.3;
                transform: translate(-50%, -50%) scale(0.95);
            }
            100% {
                opacity: 0.6;
                transform: translate(-50%, -50%) scale(1.05);
            }
        }

        .heading-subtitle {
            margin-top: 0.5rem;
            position: relative;
        }

        .subtitle-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: #475569;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative;
            display: inline-block;
            padding: 0 20px;
        }

        .subtitle-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, 
                transparent 0%, 
                rgba(14, 165, 233, 0.3) 20%, 
                rgba(14, 165, 233, 0.6) 50%, 
                rgba(14, 165, 233, 0.3) 80%, 
                transparent 100%);
            transform: translateY(-50%);
            z-index: 1;
        }

        .subtitle-text::before,
        .subtitle-text::after {
            content: '◆';
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #0ea5e9;
            font-size: 0.8rem;
            animation: diamondTwinkle 1.5s ease-in-out infinite alternate;
        }

        .subtitle-text::before {
            left: 0;
        }

        .subtitle-text::after {
            right: 0;
        }

        @keyframes diamondTwinkle {
            0% {
                opacity: 0.3;
                transform: translateY(-50%) scale(0.8);
            }
            100% {
                opacity: 1;
                transform: translateY(-50%) scale(1);
            }
        }

        /* Form - Standalone tanpa container */
        .form {
            width: 100%;
            max-width: 400px;
            padding: 0;
            background: transparent;
            border: none;
            box-shadow: none;
            backdrop-filter: none;
        }

        /* Password Wrapper */
        .password-wrapper {
            position: relative;
            width: 100%;
            margin-top: 1rem;
        }

        /* Input Fields */
        .form .input {
            width: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            font-size: 1rem;
            box-sizing: border-box;
        }

        /* Password Input khusus */
        .password-input {
            padding-right: 50px !important; /* Beri ruang untuk icon mata */
        }

        .form .input::placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            background: white;
        }

        /* Toggle Password Button */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #6b7280;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-password:hover {
            color: #0ea5e9;
            background-color: rgba(14, 165, 233, 0.1);
        }

        .toggle-password:active {
            transform: translateY(-50%) scale(0.95);
        }

        /* Eye Icon */
        .eye-icon {
            width: 20px;
            height: 20px;
            transition: all 0.2s ease;
        }

        .eye-closed {
            color: #9ca3af;
        }

        /* Login Button */
        .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            color: white;
            padding: 16px;
            margin: 2rem 0;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .form .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .form .login-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(14, 165, 233, 0.3);
        }

        .form .login-button:hover::before {
            left: 100%;
        }

        .form .login-button:active {
            transform: translateY(0);
        }

        /* Info Box */
        .info-box {
            width: 100%;
            max-width: 400px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .info-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #0ea5e9, #3b82f6);
        }

        .info-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            box-shadow: 0 4px 8px rgba(14, 165, 233, 0.2);
        }

        .info-title {
            font-weight: 700;
            color: #0369a1;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .info-text {
            color: #475569;
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .info-contact {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .contact-item svg {
            color: #0ea5e9;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .heading-text {
                font-size: 2.2rem;
            }
            
            .subtitle-text {
                font-size: 0.9rem;
                letter-spacing: 2px;
            }
            
            .heading-container {
                margin-bottom: 2rem;
            }

            .form,
            .info-box {
                max-width: 90%;
                padding: 0 1rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.querySelector('.eye-open');
            const eyeClosed = document.querySelector('.eye-closed');

            togglePassword.addEventListener('click', function() {
                // Toggle tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon mata
                if (type === 'text') {
                    eyeOpen.style.display = 'none';
                    eyeClosed.style.display = 'block';
                    this.setAttribute('title', 'Sembunyikan password');
                } else {
                    eyeOpen.style.display = 'block';
                    eyeClosed.style.display = 'none';
                    this.setAttribute('title', 'Tampilkan password');
                }
            });

            // Hover effect untuk accessibility
            togglePassword.addEventListener('mouseenter', function() {
                this.style.color = '#0ea5e9';
            });

            togglePassword.addEventListener('mouseleave', function() {
                this.style.color = '#6b7280';
            });

            // Keyboard accessibility
            togglePassword.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });

            // Tambahkan efek hover pada heading
            const headingText = document.querySelector('.heading-text');
            headingText.addEventListener('mouseenter', function() {
                this.style.animationDuration = '0.5s';
            });

            headingText.addEventListener('mouseleave', function() {
                this.style.animationDuration = '2s';
            });
        });
    </script>
</x-guest-layout>