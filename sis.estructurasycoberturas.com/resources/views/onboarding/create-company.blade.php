<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Primera Empresa - Sistema SaaS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .ob-body {font-family: 'Plus Jakarta Sans', sans-serif; background: #0f172a; color: #f8fafc; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;}
        .ob-card {background: rgba(30, 41, 59, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 24px; padding: 40px; width: 100%; max-width: 540px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);}
        .ob-badge {display: inline-flex; align-items: center; gap: 8px; background: rgba(99, 102, 241, 0.15); color: #818cf8; padding: 6px 14px; border-radius: 9999px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(99, 102, 241, 0.3);}
        .ob-title {font-size: 28px; font-weight: 800; margin: 0 0 10px 0; background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
        .ob-desc {color: #94a3b8; font-size: 15px; line-height: 1.6; margin-bottom: 30px;}
        .ob-group {margin-bottom: 22px;}
        .ob-label {display: block; font-size: 13px; font-weight: 600; color: #e2e8f0; margin-bottom: 8px;}
        .ob-input {width: 100%; box-sizing: border-box; background: rgba(15, 23, 42, 0.7); border: 1px solid #334155; border-radius: 12px; padding: 14px 16px; color: #f8fafc; font-size: 14px; outline: none; transition: all 0.2s ease;}
        .ob-input:focus {border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25);}
        .ob-grid {display: grid; grid-template-columns: 1fr 1fr; gap: 16px;}
        .ob-button {width: 100%; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #ffffff; border: none; border-radius: 12px; padding: 16px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4); margin-top: 10px;}
        .ob-button:hover {transform: translateY(-2px); box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5);}
        .ob-feature {display: flex; align-items: center; gap: 10px; background: rgba(15, 23, 42, 0.5); padding: 12px 16px; border-radius: 12px; font-size: 13px; color: #cbd5e1; margin-top: 24px; border: 1px solid rgba(255,255,255,0.05);}
    </style>
</head>
<body class="ob-body">
    <div class="ob-card">
        <div class="ob-badge">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356.257l4 4a1 1 0 001.388 0l4-4a1 1 0 01.356-.257l2.644-1.131a1 1 0 000-1.84l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-2.75-1.435A1 1 0 011.5 11.87v-1.74a1 1 0 01.81-.973l.999-.204zm13.38 0l1 1.434a1 1 0 01.81.973v1.74a1 1 0 01-.75.918 8.969 8.969 0 00-2.75 1.435V10.12l1.69-.723z"/></svg>
            Bienvenido al Sistema SaaS
        </div>

        <h1 class="ob-title">Configura tu Primera Empresa</h1>
        <p class="ob-desc">Hola <strong>{{ $user->name }}</strong>, para comenzar a emitir cotizaciones crea tu empresa. Se asignará una base de datos independiente e ultra rápida para tu cuenta.</p>

        <form action="{{ route('onboarding.store') }}" method="POST">
            @csrf

            <div class="ob-group">
                <label class="ob-label" for="business_name">Nombre de la Empresa / Razón Social *</label>
                <input class="ob-input" type="text" id="business_name" name="business_name" required placeholder="Ej: Toldos y Estructuras Perú S.A.C." value="{{ old('business_name') }}">
            </div>

            <div class="ob-grid">
                <div class="ob-group">
                    <label class="ob-label" for="tax_id">RUC / DNI (Opcional)</label>
                    <input class="ob-input" type="text" id="tax_id" name="tax_id" placeholder="Ej: 20123456789" value="{{ old('tax_id') }}">
                </div>

                <div class="ob-group">
                    <label class="ob-label" for="default_currency">Moneda Principal</label>
                    <select class="ob-input" id="default_currency" name="default_currency">
                        <option value="PEN">Soles (S/.)</option>
                        <option value="USD">Dólares (US$)</option>
                    </select>
                </div>
            </div>

            <div class="ob-group">
                <label class="ob-label" for="phone">Teléfono / Celular de Contacto</label>
                <input class="ob-input" type="text" id="phone" name="phone" placeholder="Ej: +51 987 654 321" value="{{ old('phone') }}">
            </div>

            <button type="submit" class="ob-button">
                Crear Empresa y Comenzar &rarr;
            </button>
        </form>

        <div class="ob-feature">
            <svg width="18" height="18" fill="none" stroke="#818cf8" stroke-width="2" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>Base de datos aislada e independiente con rendimiento dedicado.</span>
        </div>
    </div>
</body>
</html>
