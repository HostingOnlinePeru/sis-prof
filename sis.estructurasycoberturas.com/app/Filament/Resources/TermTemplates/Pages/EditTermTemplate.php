<?php

namespace App\Filament\Resources\TermTemplates\Pages;

use App\Filament\Resources\TermTemplates\TermTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTermTemplate extends EditRecord
{
    protected static string $resource = TermTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
