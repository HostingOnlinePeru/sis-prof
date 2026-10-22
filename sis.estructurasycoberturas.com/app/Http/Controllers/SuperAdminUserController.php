<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\User;
use App\Support\AppShell;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SuperAdminUserController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $users = User::query()
            ->withCount('companies')
            ->orderByDesc('created_at')
            ->get();

        $stats = [
            'total_users' => User::query()->count(),
            'total_tenants' => User::query()->where('role', 'tenant')->count(),
            'total_companies' => CompanySetting::query()->count(),
            'active_users' => User::query()->where('is_active', true)->count(),
        ];

        return AppShell::render($request, [
            'activePage' => 'saas_users',
            'subtitle' => 'Gestión global de cuentas de usuario y empresas de la plataforma SaaS.',
            'title' => 'Cuentas de Usuarios SaaS',
        ], 'superadmin.users.partial', [
            'users' => $users,
            'stats' => $stats,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:tenant,super_admin'],
        ]);

        User::query()->create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'is_active' => true,
        ]);

        return redirect()
            ->route('superadmin.users.index')
            ->with('status', "Cuenta '{$data['email']}' creada exitosamente. El usuario creará su primera empresa al ingresar.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:tenant,super_admin'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['string', 'min:6'];
        }

        $data = $request->validate($rules);

        $updateData = [
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'role' => $data['role'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('superadmin.users.index')
            ->with('status', "La cuenta de '{$user->name}' fue actualizada correctamente.");
    }

    public function toggleStatus(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['status' => 'No puedes desactivar tu propia cuenta de Super Admin.']);
        }

        $user->update([
            'is_active' => ! $user->is_active,
        ]);

        $statusText = $user->is_active ? 'activada' : 'suspendida';

        return redirect()
            ->route('superadmin.users.index')
            ->with('status', "La cuenta de {$user->name} fue {$statusText} correctamente.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->withErrors(['status' => 'No puedes eliminar tu propia cuenta.']);
        }

        $user->delete();

        return redirect()
            ->route('superadmin.users.index')
            ->with('status', 'Usuario eliminado de la plataforma SaaS.');
    }
}
