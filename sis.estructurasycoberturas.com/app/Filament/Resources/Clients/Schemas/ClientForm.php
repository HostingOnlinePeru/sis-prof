<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del cliente')
                    ->schema([
                        TextInput::make('name')
                            ->label('Cliente / razón social')
                            ->required()
                            ->maxLength(255),
                        Select::make('document_type')
                            ->label('Tipo de documento')
                            ->options([
                                'RUC' => 'RUC',
                                'DNI' => 'DNI',
                                'CE' => 'CE',
                                'OTRO' => 'Otro',
                            ])
                            ->default('RUC')
                            ->required(),
                        TextInput::make('document_number')
                            ->label('Número de documento')
                            ->maxLength(255),
                        TextInput::make('contact_name')
                            ->label('Contacto')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Correo')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->maxLength(255),
                        TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->maxLength(255),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->columnSpanFull()
                            ->maxLength(255),
                        Textarea::make('notes')
                            ->label('Notas')
                            ->columnSpanFull()
                            ->rows(3),
                    ])
                    ->columns(2),
            ]);
    }
}
