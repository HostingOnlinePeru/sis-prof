<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Document;
use App\Models\DocumentFolder;
use App\Support\AppShell;
use App\Support\CompanyContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentRepositoryController extends Controller
{
    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        if (! $request->user()?->canUsePhotoGallery()) {
            return redirect()->route('membership.index')
                ->withErrors(['membership' => 'El módulo de Galería de Fotos está disponible únicamente en el Plan Premium.']);
        }

        $currentFolderId = $request->integer('folder') ?: null;
        $currentFolder = $currentFolderId
            ? DocumentFolder::query()->find($currentFolderId)
            : null;
        $folderOptions = DocumentFolder::query()
            ->with('parent.parent.parent')
            ->orderBy('name')
            ->get();
        $visibleFolders = DocumentFolder::query()
            ->withCount('documents')
            ->where('parent_id', $currentFolder?->id)
            ->orderBy('name')
            ->get();
        $breadcrumbs = $this->breadcrumbs($currentFolder);

        $documents = Document::query()
            ->with('folder')
            ->when($currentFolder, fn ($query) => $query->where('document_folder_id', $currentFolder->id))
            ->when($request->filled('q'), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $query->where('title', 'like', '%'.$request->string('q').'%')
                        ->orWhere('original_name', 'like', '%'.$request->string('q').'%');
                });
            })
            ->latest()
            ->get();

        return AppShell::render($request, [
            'activePage' => 'documents',
            'subtitle' => 'Organiza las fotos de cada empresa en carpetas para usarlas en tus proformas.',
            'title' => 'Galería de fotos',
        ], 'documents.partial', [
            'breadcrumbs' => $breadcrumbs,
            'currentFolder' => $currentFolder,
            'documents' => $documents,
            'folderOptions' => $folderOptions,
            'folders' => $visibleFolders,
            'totalDocuments' => Document::query()->count(),
            'totalFolders' => DocumentFolder::query()->count(),
            'totalStorage' => Document::query()->sum('file_size'),
        ]);
    }

    public function storeFolder(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->canUsePhotoGallery(), 403);

        $data = $request->validate([
            'parent_id' => ['nullable', Rule::exists(DocumentFolder::class, 'id')],
            'name' => ['required', 'string', 'max:120'],
        ]);

        $folder = DocumentFolder::query()->create($data);

        return redirect()
            ->route('documents.index', ['folder' => $folder->id])
            ->with('status', 'Carpeta creada correctamente.');
    }

    public function upload(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->canUsePhotoGallery(), 403);

        $data = $request->validate([
            'document_folder_id' => ['nullable', Rule::exists(DocumentFolder::class, 'id')],
            'file' => ['required', 'file', 'max:20480'],
        ]);

        $file = $request->file('file');
        $folder = isset($data['document_folder_id'])
            ? DocumentFolder::query()->find($data['document_folder_id'])
            : null;

        $path = $file->store('documents/repository', 'public');

        Document::query()->create([
            'document_folder_id' => $folder?->id,
            'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'category' => $folder?->name,
            'file_path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'active' => true,
        ]);

        return redirect()
            ->route('documents.index', array_filter(['folder' => $folder?->id]))
            ->with('status', 'Archivo subido correctamente.');
    }

    public function download(Document $document): StreamedResponse
    {
        abort_unless(Storage::disk('public')->exists($document->file_path), 404);

        return Storage::disk('public')->download(
            $document->file_path,
            $document->original_name ?: basename($document->file_path)
        );
    }

    private function breadcrumbs(?DocumentFolder $folder): array
    {
        $items = [];

        while ($folder) {
            array_unshift($items, $folder);
            $folder = $folder->parent;
        }

        return $items;
    }
}
