<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Producto o servicio')
                    ->schema([
                        TextInput::make('sku')
                            ->label('Código')
                            ->maxLength(255),
                        TextInput::make('name')
                            ->label('Nombre corto')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->label('Descripción predictiva')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        TextInput::make('unit')
                            ->label('Unidad')
                            ->default('UND')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('price')
                            ->label('Precio')
                            ->numeric()
                            ->prefix('S/')
                            ->default(0)
                            ->required(),
                        Toggle::make('active')
                            ->label('Activo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
