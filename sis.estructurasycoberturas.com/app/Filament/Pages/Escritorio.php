<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Escritorio extends Page
{
    protected static bool $isDiscovered = false;

    protected static ?string $slug = '';

    protected static ?string $title = 'Escritorio';

    protected static ?string $navigationLabel = 'Escritorio';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected string $view = 'filament.pages.escritorio';
}
