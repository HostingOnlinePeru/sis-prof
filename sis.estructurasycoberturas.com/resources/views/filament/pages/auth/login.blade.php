<x-filament-panels::page.simple>
    <style>
        html, body {margin: 0 !important; padding: 0 !important; width: 100% !important; height: 100% !important; overflow-x: hidden;}
        .fi-body {margin: 0 !important; padding: 0 !important; width: 100vw !important; min-height: 100vh !important; background: #07090e !important;}
        .fi-simple-layout {min-height: 100vh !important; width: 100vw !important; margin: 0 !important; padding: 0 !important; display: flex !important; align-items: stretch !important; justify-content: stretch !important; background: #07090e !important;}
        .fi-simple-main-ctn {width: 100vw !important; height: 100vh !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-simple-main {width: 100% !important; height: 100% !important; max-width: 100% !important; padding: 0 !important; margin: 0 !important; background: transparent !important; box-shadow: none !important; border: none !important; border-radius: 0 !important;}
        .fi-simple-page {width: 100% !important; height: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-simple-page-content {width: 100% !important; height: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important;}
        .fi-logo {display: none !important;}
        .login-bg-wrapper {position: relative; width: 100vw; height: 100vh; background: #07090e; display: flex; overflow: hidden; perspective: 1200px;}
        .login-right-fullbg {position: absolute; top: -8%; right: -5%; width: 70vw; height: 116vh; z-index: 1; transform: rotateY(-12deg) rotateX(2deg); transform-origin: right center; border-radius: 18px; overflow: hidden; box-shadow: -30px 0 80px rgba(0, 0, 0, 0.6), -10px 0 30px rgba(79, 70, 229, 0.08);}
        .login-right-fullbg img {width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;}
        .login-right-fade {position: absolute; inset: 0; width: 100%; height: 100%; background: linear-gradient(to right, #07090e 0%, #07090e 20%, rgba(7, 9, 14, 0.88) 40%, rgba(7, 9, 14, 0.25) 65%, transparent 90%); z-index: 2; pointer-events: none;}
        .login-left-form-area {position: relative; z-index: 10; width: 100%; max-width: 480px; height: 100vh; margin-left: 15vw; padding: 50px 30px; display: flex; flex-direction: column; justify-content: space-between; box-sizing: border-box;}
        @media (max-width: 1200px) {.login-left-form-area {margin-left: 8vw; max-width: 440px;}}
        @media (max-width: 900px) {.login-left-form-area {margin-left: 0; max-width: 100%; padding: 36px 24px; background: #07090e;} .login-right-fullbg {display: none;}}
        .login-brand-header {display: flex; align-items: center; gap: 12px; margin-bottom: 20px;}
        .login-brand-icon {width: 42px; height: 42px; border-radius: 12px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #ffffff; display: grid; place-items: center; font-weight: 900; font-size: 16px; box-shadow: 0 8px 24px rgba(124, 58, 237, 0.45);}
        .login-brand-title {font-size: 20px; font-weight: 800; color: #f8fafc; margin: 0; letter-spacing: -0.01em;}
        .login-content-box {width: 100%; margin: auto 0;}
        .login-tag {font-size: 11px; font-weight: 800; text-transform: uppercase; color: #a78bfa; letter-spacing: 0.12em; margin-bottom: 10px;}
        .login-h1 {font-size: 32px; font-weight: 800; color: #ffffff; margin: 0 0 8px 0; letter-spacing: -0.03em;}
        .login-subtitle {font-size: 14px; color: #94a3b8; margin: 0 0 28px 0; line-height: 1.5;}
        .login-group {margin-bottom: 20px;}
        .login-label {display: block; font-size: 13px; font-weight: 600; color: #cbd5e1; margin-bottom: 8px;}
        .login-input {width: 100%; height: 46px; background: #121624; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 10px; padding: 0 16px; color: #ffffff; font-size: 14px; outline: none; transition: all 0.2s ease; box-sizing: border-box;}
        .login-input:focus {border-color: #7c3aed; background: #171d30; box-shadow: 0 0 0 4px rgba(124, 58, 237, 0.22);}
        .login-pass-wrap {position: relative; width: 100%; display: flex; align-items: center;}
        .login-pass-input {padding-right: 46px;}
        .login-eye-btn {position: absolute; right: 12px; background: transparent; border: none; padding: 6px; cursor: pointer; color: #94a3b8; display: inline-flex; align-items: center; justify-content: center; transition: color 0.2s ease; z-index: 2;}
        .login-eye-btn:hover {color: #ffffff;}
        .login-options-row {display: flex; justify-content: space-between; align-items: center; margin: 6px 0 28px;}
        .login-remember {display: flex; align-items: center; gap: 10px; cursor: pointer; font-size: 13px; color: #94a3b8;}
        .login-chk {width: 18px; height: 18px; accent-color: #7c3aed; border-radius: 4px; cursor: pointer;}
        .login-btn {width: 100%; height: 48px; background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border: none; border-radius: 12px; color: #ffffff; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 10px 25px -5px rgba(124, 58, 237, 0.45); display: flex; align-items: center; justify-content: center; gap: 10px;}
        .login-btn:hover {opacity: 0.95; transform: translateY(-1px); box-shadow: 0 15px 35px -5px rgba(124, 58, 237, 0.55);}
        .login-alert {background: rgba(220, 38, 38, 0.15); border: 1px solid rgba(220, 38, 38, 0.35); border-radius: 10px; color: #fca5a5; font-size: 13px; margin-bottom: 20px; padding: 12px 14px;}
        .login-footer-text {font-size: 12px; color: #64748b;}
    </style>

    <div class="login-bg-wrapper">
        <!-- 3D Perspective background proforma image -->
        <div class="login-right-fullbg">
            <img src="/images/proforma-bg.jpg" alt="Proforma" />
            <div class="login-right-fade"></div>
        </div>

        <!-- Form Area shifted right towards center -->
        <div class="login-left-form-area">
            <div class="login-brand-header">
                <div class="login-brand-icon">SIS</div>
                <h2 class="login-brand-title">SISPROF</h2>
            </div>

            <div class="login-content-box">
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
                            placeholder="tu-correo@empresa.com"
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
            </div>

            <div class="login-footer-text">
                &copy; {{ date('Y') }} SISPROF. Todos los derechos reservados.
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
