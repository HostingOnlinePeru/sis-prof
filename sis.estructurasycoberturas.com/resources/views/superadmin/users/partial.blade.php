<style>
.saas-grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;}
.saas-card {background: linear-gradient(180deg, rgba(255, 255, 255, 0.055), rgba(255, 255, 255, 0.025)); border: 1px solid var(--line); border-radius: 16px; padding: 20px; box-shadow: 0 18px 45px rgba(0, 0, 0, 0.22); transition: transform 0.2s ease, border-color 0.2s ease;}
.saas-card:hover {transform: translateY(-2px); border-color: rgba(99, 102, 241, 0.4);}
.saas-label {font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--muted); letter-spacing: 0.05em;}
.saas-value {font-size: 28px; font-weight: 800; color: #f8fafc; margin-top: 6px;}
.saas-box {background: linear-gradient(180deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02)); border: 1px solid var(--line); border-radius: 16px; padding: 24px; box-shadow: 0 18px 45px rgba(0, 0, 0, 0.22); margin-bottom: 24px;}
.saas-flex {display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap; margin-bottom: 20px;}
.saas-h2 {font-size: 18px; font-weight: 700; color: #f8fafc; margin: 0;}
.saas-btn {background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #ffffff; padding: 11px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);}
.saas-btn:hover {opacity: 0.95; transform: translateY(-1px); box-shadow: 0 15px 30px -5px rgba(79, 70, 229, 0.5);}
.saas-table {width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;}
.saas-th {padding: 12px 16px; font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--muted); background: rgba(255, 255, 255, 0.03); border-bottom: 1px solid var(--line);}
.saas-td {padding: 14px 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.06); color: #cbd5e1; vertical-align: middle;}
.saas-badge {display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600;}
.saas-badge-admin {background: rgba(99, 102, 241, 0.2); color: #a5b4fc; border: 1px solid rgba(99, 102, 241, 0.4);}
.saas-badge-tenant {background: rgba(148, 163, 184, 0.15); color: #cbd5e1; border: 1px solid rgba(148, 163, 184, 0.25);}
.saas-badge-active {background: rgba(34, 197, 94, 0.15); color: #86efac; border: 1px solid rgba(34, 197, 94, 0.3);}
.saas-badge-inactive {background: rgba(239, 68, 68, 0.15); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3);}
.saas-form-grid {display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-top: 16px;}
.saas-input {width: 100%; box-sizing: border-box; padding: 11px 14px; border: 1px solid var(--line); border-radius: 8px; background: var(--field); color: var(--text); font-size: 14px; outline: none; transition: border-color 0.18s ease, box-shadow 0.18s ease;}
.saas-input:focus {border-color: rgba(99, 102, 241, 0.78); box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15); background: #0f1722;}
.saas-password-wrapper {position: relative; width: 100%; display: flex; align-items: center;}
.saas-input-password {padding-right: 42px;}
.saas-password-toggle {position: absolute; right: 10px; background: transparent; border: none; padding: 4px; cursor: pointer; color: var(--muted); display: inline-flex; align-items: center; justify-content: center; transition: color 0.2s ease; z-index: 2;}
.saas-password-toggle:hover {color: #f8fafc;}
.saas-action-btn {background: none; border: none; font-weight: 600; cursor: pointer; font-size: 13px; padding: 6px 8px; border-radius: 8px; transition: all 0.15s ease; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px;}
.saas-action-edit {color: #34d399;}
.saas-action-edit:hover {color: #6ee7b7; background: rgba(52, 211, 153, 0.12);}
.saas-action-suspend {color: #fbbf24;}
.saas-action-suspend:hover {color: #fcd34d; background: rgba(251, 191, 36, 0.12);}
.saas-action-activate {color: #34d399;}
.saas-action-activate:hover {color: #6ee7b7; background: rgba(52, 211, 153, 0.12);}
.saas-action-delete {color: #f87171;}
.saas-action-delete:hover {color: #fca5a5; background: rgba(248, 113, 113, 0.12);}
.saas-modal-overlay {display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px); align-items: center; justify-content: center;}
.saas-modal-overlay.active {display: flex;}
.saas-modal {background: #0f1722; border: 1px solid var(--line); border-radius: 16px; padding: 28px 32px; width: 100%; max-width: 520px; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(99, 102, 241, 0.15); animation: saasModalIn 0.2s ease;}
@keyframes saasModalIn {from {opacity: 0; transform: scale(0.95) translateY(10px);} to {opacity: 1; transform: scale(1) translateY(0);}}
.saas-modal-title {font-size: 18px; font-weight: 700; color: #f8fafc; margin: 0 0 6px 0;}
.saas-modal-subtitle {font-size: 13px; color: var(--muted); margin: 0 0 20px 0;}
.saas-modal-field {margin-bottom: 16px;}
.saas-modal-label {display: block; font-size: 12px; font-weight: 600; color: #cbd5e1; margin-bottom: 6px;}
.saas-modal-actions {display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px;}
.saas-modal-cancel {background: rgba(255, 255, 255, 0.08); border: 1px solid var(--line); color: #cbd5e1; padding: 10px 20px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.15s ease;}
.saas-modal-cancel:hover {background: rgba(255, 255, 255, 0.12);}
.saas-modal-save {background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #ffffff; padding: 10px 24px; border-radius: 10px; font-size: 14px; font-weight: 700; border: none; cursor: pointer; transition: all 0.15s ease; box-shadow: 0 8px 20px -5px rgba(79, 70, 229, 0.4);}
.saas-modal-save:hover {opacity: 0.95; transform: translateY(-1px);}
</style>

<div class="saas-grid">
    <div class="saas-card">
        <div class="saas-label">Total Usuarios</div>
        <div class="saas-value">{{ $stats['total_users'] }}</div>
    </div>
    <div class="saas-card">
        <div class="saas-label">Cuentas Empresa</div>
        <div class="saas-value">{{ $stats['total_tenants'] }}</div>
    </div>
    <div class="saas-card">
        <div class="saas-label">Empresas Registradas</div>
        <div class="saas-value">{{ $stats['total_companies'] }}</div>
    </div>
    <div class="saas-card">
        <div class="saas-label">Cuentas Activas</div>
        <div class="saas-value">{{ $stats['active_users'] }}</div>
    </div>
</div>

<div class="saas-box">
    <div class="saas-flex">
        <div>
            <h2 class="saas-h2">Crear Nueva Cuenta de Usuario SaaS</h2>
            <p style="font-size: 13px; color: var(--muted); margin: 4px 0 0 0;">El nuevo usuario registrará su propia empresa e instanciará su base de datos al iniciar sesión por primera vez.</p>
        </div>
    </div>

    <form action="{{ route('superadmin.users.store') }}" method="POST">
        @csrf
        <div class="saas-form-grid">
            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Nombre del Usuario *</label>
                <input type="text" name="name" class="saas-input" required placeholder="Ej. Juan Pérez">
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Correo Electrónico *</label>
                <input type="email" name="email" class="saas-input" required placeholder="ejemplo@empresa.com">
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Contraseña *</label>
                <div class="saas-password-wrapper">
                    <input type="password" id="saas-create-password" name="password" class="saas-input saas-input-password" required placeholder="••••••••">
                    <button type="button" class="saas-password-toggle" onclick="togglePasswordVisibility('saas-create-password', this)" aria-label="Mostrar u ocultar contraseña" title="Mostrar/Ocultar contraseña">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:600; color:#cbd5e1; margin-bottom:6px;">Tipo de Cuenta / Rol *</label>
                <select name="role" class="saas-input" required>
                    <option value="tenant">Empresa (Multi-empresa)</option>
                    <option value="super_admin">Super Administrador SaaS</option>
                </select>
            </div>
        </div>

        <div style="margin-top: 20px; text-align: right;">
            <button type="submit" class="saas-btn">
                + Crear Cuenta de Usuario
            </button>
        </div>
    </form>
</div>

<div class="saas-box">
    <div class="saas-flex">
        <h2 class="saas-h2">Directorio de Cuentas de Usuario</h2>
    </div>

    <div style="overflow-x: auto;">
        <table class="saas-table">
            <thead>
                <tr>
                    <th class="saas-th">Usuario</th>
                    <th class="saas-th">Correo Electrónico</th>
                    <th class="saas-th">Rol</th>
                    <th class="saas-th">Empresas</th>
                    <th class="saas-th">Estado</th>
                    <th class="saas-th">Membresía</th>
                    <th class="saas-th">Registro</th>
                    <th class="saas-th" style="text-align: right;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td class="saas-td">
                            <strong style="color:#f8fafc;">{{ $user->name }}</strong>
                        </td>
                        <td class="saas-td">{{ $user->email }}</td>
                        <td class="saas-td">
                            @if($user->isSuperAdmin())
                                <span class="saas-badge saas-badge-admin">Super Admin</span>
                            @else
                                <span class="saas-badge saas-badge-tenant">Empresa</span>
                            @endif
                        </td>
                        <td class="saas-td">
                            <span style="font-weight: 700; color: #f8fafc;">{{ $user->companies_count }}</span> empresa(s)
                        </td>
                        <td class="saas-td">
                            @if($user->is_active)
                                <span class="saas-badge saas-badge-active">Activo</span>
                            @else
                                <span class="saas-badge saas-badge-inactive">Suspendido</span>
                            @endif
                        </td>
                        <td class="saas-td">
                            @if($user->isSuperAdmin())
                                <span style="color:var(--muted);">—</span>
                            @elseif($user->hasActiveMembership())
                                <span class="saas-badge {{ $user->isPremium() ? 'saas-badge-admin' : 'saas-badge-tenant' }}" style="margin-right:4px;">{{ $user->currentTierLabel() }}</span>
                                <span class="saas-badge {{ $user->membershipDaysLeft() <= 7 ? 'saas-badge-tenant' : 'saas-badge-active' }}">Vence {{ $user->membership_ends_at->format('d/m/Y') }}</span>
                            @else
                                <span class="saas-badge saas-badge-inactive">Vencida ({{ $user->currentTierLabel() }})</span>
                            @endif
                        </td>
                        <td class="saas-td">{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                        <td class="saas-td" style="text-align: right;">
                            @if($user->id !== auth()->id())
                                <button type="button" class="saas-action-btn saas-action-edit" title="Editar usuario" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>

                                <form action="{{ route('superadmin.users.toggle-status', $user) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->is_active)
                                        <button type="submit" class="saas-action-btn saas-action-suspend" title="Suspender usuario">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><circle cx="12" cy="12" r="10"/><line x1="10" y1="15" x2="10" y2="9"/><line x1="14" y1="15" x2="14" y2="9"/></svg>
                                        </button>
                                    @else
                                        <button type="submit" class="saas-action-btn saas-action-activate" title="Activar usuario">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><circle cx="12" cy="12" r="10"/><polygon points="10,8 16,12 10,16 10,8"/></svg>
                                        </button>
                                    @endif
                                </form>

                                <form action="{{ route('superadmin.users.destroy', $user) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="saas-action-btn saas-action-delete" title="Eliminar usuario">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="saas-action-btn saas-action-edit" title="Editar tu cuenta" onclick="openEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->email }}', '{{ $user->role }}')">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </button>
                                <span style="font-size:12px; color:var(--muted); margin-left: 4px;">Tu cuenta</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="saas-td" style="text-align: center; color: var(--muted); padding: 30px;">
                            No existen cuentas de usuario registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Editar Usuario -->
<div id="editUserModal" class="saas-modal-overlay" onclick="if(event.target===this) closeEditModal();">
    <div class="saas-modal">
        <h3 class="saas-modal-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;vertical-align:middle;margin-right:6px;"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Editar Usuario
        </h3>
        <p class="saas-modal-subtitle">Modifica los datos de la cuenta. Deja la contraseña vacía si no deseas cambiarla.</p>

        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')

            <div class="saas-modal-field">
                <label class="saas-modal-label">Nombre del Usuario *</label>
                <input type="text" id="edit-user-name" name="name" class="saas-input" required placeholder="Nombre completo">
            </div>

            <div class="saas-modal-field">
                <label class="saas-modal-label">Correo Electrónico *</label>
                <input type="email" id="edit-user-email" name="email" class="saas-input" required placeholder="correo@empresa.com">
            </div>

            <div class="saas-modal-field">
                <label class="saas-modal-label">Nueva Contraseña <span style="color:var(--muted);font-weight:400;">(opcional)</span></label>
                <div class="saas-password-wrapper">
                    <input type="password" id="edit-user-password" name="password" class="saas-input saas-input-password" placeholder="Dejar vacío para no cambiar">
                    <button type="button" class="saas-password-toggle" onclick="togglePasswordVisibility('edit-user-password', this)" aria-label="Mostrar u ocultar contraseña">
                        <svg class="eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="eye-closed" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:18px;height:18px;display:none;"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                    </button>
                </div>
            </div>

            <div class="saas-modal-field">
                <label class="saas-modal-label">Tipo de Cuenta / Rol *</label>
                <select id="edit-user-role" name="role" class="saas-input" required>
                    <option value="tenant">Empresa (Multi-empresa)</option>
                    <option value="super_admin">Super Administrador SaaS</option>
                </select>
            </div>

            <div class="saas-modal-actions">
                <button type="button" class="saas-modal-cancel" onclick="closeEditModal()">Cancelar</button>
                <button type="submit" class="saas-modal-save">
                    Guardar Cambios
                </button>
            </div>
        </form>
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

window.openEditModal = function openEditModal(userId, userName, userEmail, userRole) {
    const form = document.getElementById('editUserForm');
    if (form) form.action = '/admin/usuarios/' + userId;
    const nameEl = document.getElementById('edit-user-name');
    const emailEl = document.getElementById('edit-user-email');
    const passEl = document.getElementById('edit-user-password');
    const roleEl = document.getElementById('edit-user-role');
    const modalEl = document.getElementById('editUserModal');
    if (nameEl) nameEl.value = userName;
    if (emailEl) emailEl.value = userEmail;
    if (passEl) passEl.value = '';
    if (roleEl) roleEl.value = userRole;
    if (modalEl) modalEl.classList.add('active');
};

window.closeEditModal = function closeEditModal() {
    const modalEl = document.getElementById('editUserModal');
    if (modalEl) modalEl.classList.remove('active');
};

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') window.closeEditModal();
});
</script>

