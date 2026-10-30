<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Support\AppShell;
use App\Support\CompanyContext;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductCatalogController extends Controller
{
    private function ensureProductsModuleAllowed(Request $request): ?RedirectResponse
    {
        $user = $request->user();
        if (! $user || $user->canUseProductsModule()) {
            return null;
        }

        return redirect()
            ->route('membership.index')
            ->withErrors(['membership' => 'El módulo de Productos está disponible únicamente en el Plan Premium (PRO).']);
    }

    public function index(Request $request): View|JsonResponse|RedirectResponse
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $currentCategoryId = $request->integer('category') ?: null;
        $currentCategory = $currentCategoryId
            ? ProductCategory::query()->find($currentCategoryId)
            : null;

        $editingProduct = $request->integer('edit')
            ? Product::query()->find($request->integer('edit'))
            : null;

        $products = Product::query()
            ->with('category')
            ->when($currentCategory, fn ($query) => $query->where('product_category_id', $currentCategory->id))
            ->when($request->filled('q'), function ($query) use ($request): void {
                $query->where(function ($query) use ($request): void {
                    $query->where('name', 'like', '%'.$request->string('q').'%')
                        ->orWhere('sku', 'like', '%'.$request->string('q').'%')
                        ->orWhere('description', 'like', '%'.$request->string('q').'%');
                });
            })
            ->latest()
            ->get();

        return AppShell::render($request, [
            'activePage' => 'products',
            'subtitle' => 'Crea categorías y productos reutilizables para traer sus descripciones a las proformas.',
            'title' => 'Productos',
        ], 'products.partial', [
            'categories' => ProductCategory::query()->withCount('products')->orderBy('name')->get(),
            'currentCategory' => $currentCategory,
            'editingProduct' => $editingProduct,
            'products' => $products,
            'totalActiveProducts' => Product::query()->where('active', true)->count(),
            'totalCategories' => ProductCategory::query()->count(),
            'totalProducts' => Product::query()->count(),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category = ProductCategory::query()->create($data);
        session()->flash('status', 'Categoría creada correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['category' => $category->id]));
        }

        return redirect()
            ->route('products.index', ['category' => $category->id])
            ->with('status', 'Categoría creada correctamente.');
    }

    public function updateCategory(Request $request, ProductCategory $category): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update($data);
        session()->flash('status', 'Categoría actualizada correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['category' => $category->id]));
        }

        return redirect()
            ->route('products.index', ['category' => $category->id])
            ->with('status', 'Categoría actualizada correctamente.');
    }

    public function destroyCategory(Request $request, ProductCategory $category): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        Product::query()->where('product_category_id', $category->id)->update(['product_category_id' => null]);
        $category->delete();
        session()->flash('status', 'Categoría eliminada correctamente.');

        $nextCategoryId = $request->integer('category') === $category->id ? null : $request->integer('category');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['category' => $nextCategoryId ?: null]));
        }

        return redirect()
            ->route('products.index', array_filter(['category' => $nextCategoryId]))
            ->with('status', 'Categoría eliminada correctamente.');
    }

    public function storeProduct(Request $request): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $user = $request->user();
        $currentCount = Product::query()->count();

        if ($user && ! $user->canCreateProduct($currentCount)) {
            $max = $user->maxProducts();

            return redirect()
                ->route('products.index')
                ->withErrors([
                    'name' => "Has alcanzado el límite máximo de {$max} productos permitidos en el Plan Premium ({$currentCount}/{$max}).",
                ]);
        }

        $data = $this->validateProduct($request);
        $data['active'] = $request->boolean('active');

        $product = Product::query()->create($data);
        session()->flash('status', 'Producto guardado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge([
                'category' => $product->product_category_id,
            ]));
        }

        return redirect()
            ->route('products.index', array_filter([
                'category' => $product->product_category_id,
            ]))
            ->with('status', 'Producto guardado correctamente.');
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $data = $this->validateProduct($request);
        $data['active'] = $request->boolean('active');

        $product->update($data);
        session()->flash('status', 'Producto actualizado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge([
                'category' => $product->product_category_id,
            ]));
        }

        return redirect()
            ->route('products.index', array_filter([
                'category' => $product->product_category_id,
            ]))
            ->with('status', 'Producto actualizado correctamente.');
    }

    public function destroyProduct(Request $request, Product $product): RedirectResponse|JsonResponse|View
    {
        if ($denied = $this->ensureProductsModuleAllowed($request)) {
            return $denied;
        }

        $categoryId = $product->product_category_id;
        $product->delete();
        session()->flash('status', 'Producto eliminado correctamente.');

        if ($request->header('X-App-Partial') === '1' || $request->expectsJson()) {
            return $this->index($request->merge(['category' => $categoryId]));
        }

        return redirect()
            ->route('products.index', array_filter(['category' => $categoryId]))
            ->with('status', 'Producto eliminado correctamente.');
    }

    private function validateProduct(Request $request): array
    {
        $data = $request->validate([
            'product_category_id' => ['nullable', Rule::exists(ProductCategory::class, 'id')],
            'sku' => ['nullable', 'string', 'max:80'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'unit' => ['required', 'string', 'max:20'],
            'price' => ['required', 'numeric', 'min:0'],
        ]);

        $data['description'] = $data['description'] ?? '';

        return $data + ['tax_rate' => 18];
    }
}
