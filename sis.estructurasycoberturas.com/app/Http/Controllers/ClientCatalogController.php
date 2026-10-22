<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Support\AppShell;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClientCatalogController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $editingClient = $request->integer('edit')
            ? Client::query()->find($request->integer('edit'))
            : null;

        $clients = Client::query()
            ->when($request->filled('q'), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $query->where('name', 'like', '%'.$request->string('q').'%')
                        ->orWhere('company_name', 'like', '%'.$request->string('q').'%')
                        ->orWhere('document_number', 'like', '%'.$request->string('q').'%')
                        ->orWhere('email', 'like', '%'.$request->string('q').'%')
                        ->orWhere('phone', 'like', '%'.$request->string('q').'%');
                });
            })
            ->latest()
            ->get();

        return AppShell::render($request, [
            'activePage' => 'clients',
            'subtitle' => 'Registra los datos del cliente para dirigir proformas y preparar envíos por correo.',
            'title' => 'Clientes',
        ], 'clients.partial', [
            'clients' => $clients,
            'editingClient' => $editingClient,
            'totalClients' => Client::query()->count(),
            'totalClientsWithEmail' => Client::query()->whereNotNull('email')->where('email', '!=', '')->count(),
            'totalClientsWithRuc' => Client::query()->where('document_type', 'RUC')->whereNotNull('document_number')->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse|View
    {
        $client = Client::query()->create($this->validatedData($request));
        session()->flash('status', 'Cliente guardado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['edit' => $client->id]));
        }

        return redirect()
            ->route('clients.index', ['edit' => $client->id])
            ->with('status', 'Cliente guardado correctamente.');
    }

    public function update(Request $request, Client $client): RedirectResponse|JsonResponse|View
    {
        $client->update($this->validatedData($request));
        session()->flash('status', 'Cliente actualizado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['edit' => $client->id]));
        }

        return redirect()
            ->route('clients.index', ['edit' => $client->id])
            ->with('status', 'Cliente actualizado correctamente.');
    }

    public function destroy(Request $request, Client $client): RedirectResponse|JsonResponse|View
    {
        $client->delete();
        session()->flash('status', 'Cliente eliminado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request);
        }

        return redirect()
            ->route('clients.index')
            ->with('status', 'Cliente eliminado correctamente.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'document_number' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:255'],
        ]) + [
            'document_type' => 'RUC',
        ];
    }
}
