<?php

namespace App\Filament\Resources\TermTemplates;

use App\Filament\Resources\TermTemplates\Pages\CreateTermTemplate;
use App\Filament\Resources\TermTemplates\Pages\EditTermTemplate;
use App\Filament\Resources\TermTemplates\Pages\ListTermTemplates;
use App\Filament\Resources\TermTemplates\Schemas\TermTemplateForm;
use App\Filament\Resources\TermTemplates\Tables\TermTemplatesTable;
use App\Models\TermTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TermTemplateResource extends Resource
{
    protected static ?string $model = TermTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'plantilla de términos';

    protected static ?string $pluralModelLabel = 'plantillas de términos';

    protected static ?string $navigationLabel = 'Términos';

    protected static string|\UnitEnum|null $navigationGroup = 'Catálogos';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return TermTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TermTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTermTemplates::route('/'),
            'create' => CreateTermTemplate::route('/create'),
            'edit' => EditTermTemplate::route('/{record}/edit'),
        ];
    }
}
