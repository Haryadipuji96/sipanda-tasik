<x-guest-layout>
    <div class="container">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/Logo-IAIT.png') }}" alt="Logo SIPANDA" class="mx-auto w-24 h-24">
        </div>

        <div class="heading">Login SIPANDA</div>

        <form method="POST" action="{{ route('login') }}" class="form">
            @csrf

            <!-- Email -->
            <input required class="input" type="email" name="email" id="email" placeholder="E-mail" :value="old('email')" autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />

            <!-- Password -->
            <input required class="input" type="password" name="password" id="password" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <!-- Remember Me & Forgot Password -->
            <div class="flex justify-between mt-2 items-center text-sm text-gray-600">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="ml-2">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="underline text-blue-600 hover:text-blue-800">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <input class="login-button mt-6" type="submit" value="Login SIPANDA">
        </form>

        <!-- Info Box untuk yang belum punya akun -->
        <div class="info-box">
            <div class="info-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="info-content">
                <h3 class="info-title">Belum punya akun?</h3>
                <p class="info-text">
                    Sistem login ini khusus untuk pengguna terdaftar. Jika Anda belum memiliki akun, 
                    silakan hubungi <strong>Administrator</strong> untuk membuatkan akun baru.
                </p>
                <div class="info-contact">
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span>Hubungi Admin</span>
                    </div>
                    <div class="contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>admin@iaitasik.ac.id</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Container */
        .container {
            max-width: 400px;
            background: linear-gradient(0deg, #fff 0%, #f4f7fb 100%);
            border-radius: 40px;
            padding: 25px 35px;
            border: 5px solid #fff;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 30px 30px -20px;
            margin: 20px auto;
        }

        /* Heading */
        .heading {
            text-align: center;
            font-weight: 900;
            font-size: 30px;
            color: rgb(71, 71, 71);
            margin-bottom: 20px;
        }

        /* Form Inputs */
        .form .input {
            width: 100%;
            background: white;
            border: none;
            padding: 15px 20px;
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: #cff0ff 0px 10px 10px -5px;
            border-inline: 2px solid transparent;
        }

        .form .input::placeholder {
            color: rgb(170, 170, 170);
        }

        .form .input:focus {
            outline: none;
            border-inline: 2px solid #12B1D1;
        }

        /* Login Button */
        .form .login-button {
            display: block;
            width: 100%;
            font-weight: bold;
            background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
            color: white;
            padding-block: 15px;
            margin: 20px auto;
            border-radius: 20px;
            box-shadow: rgba(133, 189, 215, 0.88) 0px 20px 10px -15px;
            border: none;
            transition: all 0.2s ease-in-out;
        }

        .form .login-button:hover {
            transform: scale(1.03);
            box-shadow: rgba(133, 189, 215, 0.88) 0px 23px 10px -20px;
        }

        .form .login-button:active {
            transform: scale(0.95);
            box-shadow: rgba(133, 189, 215, 0.88) 0px 15px 10px -10px;
        }

        /* Info Box Styling */
        .info-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #bae6fd;
            border-radius: 16px;
            padding: 16px;
            margin-top: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            box-shadow: 0 4px 12px rgba(186, 230, 253, 0.3);
        }

        .info-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-title {
            font-weight: 700;
            color: #0369a1;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .info-text {
            color: #475569;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .info-contact {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 11px;
        }

        .contact-item svg {
            color: #0ea5e9;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                padding: 20px 25px;
            }
            
            .info-box {
                flex-direction: column;
                text-align: center;
            }
            
            .info-icon {
                align-self: center;
            }
        }
    </style>
</x-guest-layout>