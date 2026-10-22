<?php

namespace App\Http\Controllers;

use App\Models\TermTemplate;
use App\Support\AppShell;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermTemplateController extends Controller
{
    public function index(Request $request): View|JsonResponse
    {
        $editingTerm = TermTemplate::query()->where('active', true)->latest()->first()
            ?? TermTemplate::query()->latest()->first();

        return AppShell::render($request, [
            'activePage' => 'terms',
            'subtitle' => 'Crea textos de términos y condiciones con formato para insertarlos en tus proformas.',
            'title' => 'Términos y Condiciones',
        ], 'terms.partial', [
            'editingTerm' => $editingTerm,
            'terms' => $editingTerm ? collect([$editingTerm]) : collect(),
            'totalActiveTerms' => $editingTerm ? 1 : 0,
            'totalTerms' => $editingTerm ? 1 : 0,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['active'] = true;

        $term = TermTemplate::query()->where('active', true)->latest()->first()
            ?? TermTemplate::query()->latest()->first();

        if ($term) {
            $term->update($data);
            TermTemplate::query()->whereKeyNot($term->id)->update(['active' => false]);

            return redirect()
                ->route('terms.index')
                ->with('status', 'Términos y condiciones actualizados correctamente.');
        }

        $term = TermTemplate::query()->create($data);
        TermTemplate::query()->whereKeyNot($term->id)->update(['active' => false]);

        return redirect()
            ->route('terms.index', ['edit' => $term->id])
            ->with('status', 'Términos guardados correctamente.');
    }

    public function update(Request $request, TermTemplate $term): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['active'] = true;

        TermTemplate::query()->whereKeyNot($term->id)->update(['active' => false]);

        $term->update($data);

        return redirect()
            ->route('terms.index', ['edit' => $term->id])
            ->with('status', 'Términos actualizados correctamente.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:15000'],
        ]);

        $data['content'] = strip_tags($data['content'], [
            'a',
            'b',
            'blockquote',
            'br',
            'del',
            'div',
            'em',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'hr',
            'i',
            'li',
            'ol',
            'p',
            's',
            'span',
            'strike',
            'strong',
            'sub',
            'sup',
            'u',
            'ul',
        ]);

        return $data;
    }
}
