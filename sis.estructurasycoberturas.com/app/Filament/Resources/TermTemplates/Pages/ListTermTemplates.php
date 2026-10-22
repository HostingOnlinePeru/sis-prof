<?php

namespace App\Filament\Resources\TermTemplates\Pages;

use App\Filament\Resources\TermTemplates\TermTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTermTemplates extends ListRecords
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
