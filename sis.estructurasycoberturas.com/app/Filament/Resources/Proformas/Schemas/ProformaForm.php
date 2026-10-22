<?php

namespace App\Filament\Resources\Proformas\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProformaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cabecera')
                    ->schema([
                        TextInput::make('number')
                            ->label('Número')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Se genera automaticamente'),
                        Select::make('client_id')
                            ->label('Cliente')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')->label('Cliente / razón social')->required(),
                                Select::make('document_type')
                                    ->label('Tipo documento')
                                    ->options(['RUC' => 'RUC', 'DNI' => 'DNI', 'CE' => 'CE', 'OTRO' => 'Otro'])
                                    ->default('RUC')
                                    ->required(),
                                TextInput::make('document_number')->label('Número documento'),
                                TextInput::make('email')->label('Correo')->email(),
                                TextInput::make('whatsapp')->label('WhatsApp'),
                                TextInput::make('address')->label('Dirección')->columnSpanFull(),
                            ])
                            ->required(),
                        TextInput::make('subject')
                            ->label('Asunto')
                            ->columnSpanFull(),
                        DatePicker::make('issue_date')
                            ->label('Fecha')
                            ->default(now())
                            ->required(),
                        DatePicker::make('valid_until')
                            ->label('Válida hasta'),
                        Select::make('template')
                            ->label('Plantilla PDF')
                            ->options([
                                'commercial' => 'Modelo 1',
                                'technical' => 'Modelo 2',
                            ])
                            ->default('commercial')
                            ->required(),
                        Select::make('currency')
                            ->label('Moneda')
                            ->options([
                                'PEN' => 'PEN',
                                'USD' => 'USD',
                            ])
                            ->default('PEN')
                            ->required(),
                    ])
                    ->columns(3),

                Section::make('Ítems')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Hidden::make('sort'),
                                Select::make('product_id')
                                    ->label('Producto base')
                                    ->relationship('product', 'name', modifyQueryUsing: fn ($query) => $query->where('active', true))
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state): void {
                                        $product = Product::find($state);

                                        if (! $product) {
                                            return;
                                        }

                                        $set('description', $product->description);
                                        $set('unit', $product->unit);
                                        $set('unit_price', $product->price);
                                    }),
                                Textarea::make('description')
                                    ->label('Descripción')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('unit')
                                    ->label('Unidad')
                                    ->default('UND')
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label('Cantidad')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                TextInput::make('unit_price')
                                    ->label('Precio unitario')
                                    ->numeric()
                                    ->default(0)
                                    ->required(),
                            ])
                            ->columns(4)
                            ->orderColumn('sort')
                            ->defaultItems(1)
                            ->addActionLabel('Agregar ítem')
                            ->columnSpanFull(),
                    ]),

                Section::make('Términos y documentos')
                    ->schema([
                        Select::make('documents')
                            ->label('PDFs adjuntos del repositorio')
                            ->relationship('documents', 'title', modifyQueryUsing: fn ($query) => $query->where('active', true))
                            ->multiple()
                            ->searchable()
                            ->preload(),
                        RichEditor::make('terms')
                            ->label('Términos y condiciones')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Totales')
                    ->schema([
                        TextInput::make('subtotal')->label('Subtotal')->disabled()->dehydrated(false),
                        TextInput::make('tax_total')->label('IGV')->disabled()->dehydrated(false),
                        TextInput::make('total')->label('Total')->disabled()->dehydrated(false),
                    ])
                    ->columns(3),
            ]);
    }
}
