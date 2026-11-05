<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class TemplateCatalog
{
    public static function all(): Collection
    {
        $builtIn = collect([
            [
                'slug' => 'commercial',
                'name' => 'Modelo 1: Comercial Clásico',
                'category' => 'Comercial',
                'is_free' => true,
                'price_usd' => 0.00,
                'preview_image' => null,
                'thumbnail_image' => null,
                'description' => 'Diseño comercial limpio con cabecera corporativa, panel de contacto, tabla de ítems y cinta inferior personalizable.',
                'styles' => [
                    'primary_color' => '#0f3b57',
                    'accent_color' => '#f5a400',
                    'background_color' => '#ffffff',
                    'font_family' => 'Helvetica, Arial, sans-serif',
                ],
            ],
            [
                'slug' => 'technical',
                'name' => 'Modelo 2: Técnico Estructurado',
                'category' => 'Ingeniería / Técnico',
                'is_free' => true,
                'price_usd' => 0.00,
                'preview_image' => null,
                'thumbnail_image' => null,
                'description' => 'Diseño técnico de alto contraste enfocado en especificaciones técnicas, unidades de medida y desglose detallado.',
                'styles' => [
                    'primary_color' => '#1e293b',
                    'accent_color' => '#3b82f6',
                    'background_color' => '#ffffff',
                    'font_family' => 'Helvetica, Arial, sans-serif',
                ],
            ],
        ]);

        $custom = collect();
        $templatesPath = resource_path('templates');

        if (File::exists($templatesPath)) {
            $files = File::files($templatesPath);
            foreach ($files as $file) {
                if ($file->getExtension() === 'json') {
                    $json = json_decode(File::get($file->getPathname()), true);
                    if ($json && isset($json['slug'])) {
                        $custom->push([
                            'slug' => $json['slug'],
                            'name' => $json['name'] ?? ucfirst(str_replace('-', ' ', $json['slug'])),
                            'category' => $json['category'] ?? 'General',
                            'is_free' => (bool) ($json['is_free'] ?? false),
                            'price_usd' => (float) ($json['price_usd'] ?? 5.00),
                            'preview_image' => $json['preview_image'] ?? null,
                            'thumbnail_image' => $json['thumbnail_image'] ?? null,
                            'description' => $json['description'] ?? '',
                            'styles' => $json['styles'] ?? [],
                            'custom_css' => $json['custom_css'] ?? null,
                            'html_template' => $json['html_template'] ?? null,
                        ]);
                    }
                }
            }
        }

        return $builtIn->concat($custom)->keyBy('slug');
    }

    public static function find(string $slug): ?array
    {
        return static::all()->get($slug);
    }

    public static function forUser(?User $user): Collection
    {
        return static::all()->map(function ($template) use ($user) {
            $isUnlocked = $template['is_free'] || ($user && $user->hasUnlockedTemplate($template['slug']));
            $template['is_unlocked'] = $isUnlocked;
            return $template;
        });
    }

    public static function unlockedForUser(?User $user): Collection
    {
        return static::forUser($user)->filter(fn ($t) => $t['is_unlocked']);
    }
}
