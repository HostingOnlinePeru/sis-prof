<x-filament-panels::page.simple>
    <style>
        html, body {margin: 0 !important; padding: 0 !important; width: 100% !important; height: 100% !important; overflow-x: hidden;}
        .fi-body {margin: 0 !important; padding: 0 !important; width: 100vw !important; min-height: 100vh !important; background: #060711 !important;}
        .fi-simple-layout {min-height: 100vh !important; width: 100vw !important; margin: 0 !important; padding: 0 !important; display: flex !important; align-items: stretch !important; justify-content: stretch !important; background: #060711 !important;}
        .fi-simple-main-ctn {width: 100vw !important; height: 100vh !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-simple-main {width: 100% !important; height: 100% !important; max-width: 100% !important; padding: 0 !important; margin: 0 !important; background: transparent !important; box-shadow: none !important; border: none !important; border-radius: 0 !important;}
        .fi-simple-page {width: 100% !important; height: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-simple-page-content {width: 100% !important; height: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-logo {display: none !important;}
        .login-bg-wrapper {position: relative; width: 100vw; min-height: 100vh; height: 100vh; background-color: #060711; background-image: url('/images/login-bg.jpg'); background-position: center right; background-size: cover; background-repeat: no-repeat; display: flex; align-items: center; justify-content: flex-start; overflow: hidden;}
        .login-bg-overlay {position: absolute; inset: 0; width: 100%; height: 100%; background: linear-gradient(90deg, rgba(6, 7, 17, 0.85) 0%, rgba(6, 7, 17, 0.6) 40%, rgba(6, 7, 17, 0.15) 70%, transparent 100%); pointer-events: none; z-index: 1;}
        .login-card-container {position: relative; z-index: 10; margin-left: 10vw; width: 100%; max-width: 440px; box-sizing: border-box;}
        @media (max-width: 1200px) {.login-card-container {margin-left: 6vw; max-width: 420px;}}
        @media (max-width: 900px) {.login-bg-wrapper {justify-content: center; background-position: 70% center;} .login-card-container {margin-left: 0; padding: 20px; max-width: 440px;}}
        .login-card {background: radial-gradient(circle at 85% 15%, rgba(98, 58, 170, 0.88) 0%, rgba(50, 30, 85, 0.92) 42%, rgba(18, 14, 34, 0.97) 85%), rgba(18, 14, 34, 0.95); border: 1px solid rgba(255, 255, 255, 0.14); border-radius: 24px; padding: 40px 34px; box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.75), 0 0 50px rgba(98, 58, 170, 0.22); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); box-sizing: border-box;}
        .login-tag {font-size: 11px; font-weight: 800; text-transform: uppercase; color: #bca4f5; letter-spacing: 0.14em; margin-bottom: 12px;}
        .login-h1 {font-size: 32px; font-weight: 800; color: #ffffff; margin: 0 0 8px 0; letter-spacing: -0.025em; line-height: 1.15;}
        .login-subtitle {font-size: 13.5px; color: #cbd5e1; margin: 0 0 26px 0; line-height: 1.5; opacity: 0.88;}
        .login-alert {background: rgba(220, 38, 38, 0.2); border: 1px solid rgba(220, 38, 38, 0.4); border-radius: 12px; color: #fca5a5; font-size: 13px; margin-bottom: 20px; padding: 12px 14px;}
        .login-group {margin-bottom: 20px;}
        .login-label {display: block; font-size: 13px; font-weight: 600; color: #f1f5f9; margin-bottom: 8px;}
        .login-input {width: 100%; height: 48px; background: #111425; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 12px; padding: 0 16px; color: #ffffff; font-size: 14px; outline: none; transition: all 0.2s ease; box-sizing: border-box;}
        .login-input:focus {border-color: #7537e2; background: #14182e; box-shadow: 0 0 0 3px rgba(117, 55, 226, 0.3);}
        .login-pass-wrap {position: relative; width: 100%; display: flex; align-items: center;}
        .login-pass-input {padding-right: 48px;}
        .login-eye-btn {position: absolute; right: 12px; background: transparent; border: none; padding: 6px; cursor: pointer; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; transition: color 0.2s ease; z-index: 2;}
        .login-eye-btn:hover {color: #ffffff;}
        .login-options-row {display: flex; justify-content: space-between; align-items: center; margin: 16px 0 24px;}
        .login-remember {display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px; color: #cbd5e1;}
        .login-chk {width: 18px; height: 18px; accent-color: #7537e2; border-radius: 4px; cursor: pointer; background: #111425;}
        .login-btn {width: 100%; height: 50px; background: linear-gradient(90deg, #5140dc 0%, #7537e2 100%); border: none; border-radius: 12px; color: #ffffff; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 10px 25px -4px rgba(117, 55, 226, 0.5); display: flex; align-items: center; justify-content: center; gap: 8px;}
        .login-btn:hover {opacity: 0.95; transform: translateY(-1px); box-shadow: 0 14px 30px -4px rgba(117, 55, 226, 0.65);}
        .login-footer-copy {text-align: center; margin-top: 18px; font-size: 11px; color: rgba(255, 255, 255, 0.35);}
    </style>

    <div class="login-bg-wrapper">
        <div class="login-bg-overlay"></div>

        <div class="login-card-container">
            <div class="login-card">
                <div class="login-tag">Plataforma SaaS</div>
                <h1 class="login-h1">Iniciar Sesión</h1>
                <p class="login-subtitle">Ingresa tus credenciales para acceder a la gestión multiempresa de proformas.</p>

                @if ($errors->any())
                    <div class="login-alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.local') }}">
                    @csrf

                    <div class="login-group">
                        <label for="email" class="login-label">Correo electrónico</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', 'superadmin@sistema.com') }}"
                            autocomplete="email"
                            required
                            autofocus
                            class="login-input"
                            placeholder="superadmin@sistema.com"
                        />
                    </div>

                    <div class="login-group">
                        <label for="password" class="login-label">Contraseña</label>
                        <div class="login-pass-wrap">
                            <input
                                id="login-password"
                                name="password"
                                type="password"
                                value="admin123"
                                autocomplete="current-password"
                                required
                                class="login-input login-pass-input"
                                placeholder="••••••••"
                            />
                            <button type="button" class="login-eye-btn" onclick="togglePasswordVisibility('login-password', this)" aria-label="Mostrar u ocultar contraseña" title="Mostrar/Ocultar contraseña">
                                <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="login-options-row">
                        <label class="login-remember">
                            <input type="checkbox" name="remember" value="1" class="login-chk" />
                            <span>Recordarme</span>
                        </label>
                    </div>

                    <button type="submit" class="login-btn">
                        <span>Ingresar a la Plataforma</span>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </button>
                </form>

                <div class="login-footer-copy">
                    &copy; {{ date('Y') }} SISPROF. Todos los derechos reservados.
                </div>
            </div>
        </div>
    </div>

    <script>
    if (typeof window.togglePasswordVisibility === 'undefined') {
        window.togglePasswordVisibility = function(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            if (eyeOpen && eyeClosed) {
                eyeOpen.style.display = isPassword ? 'none' : 'block';
                eyeClosed.style.display = isPassword ? 'block' : 'none';
            }
        };
    }
    </script>
</x-filament-panels::page.simple>
