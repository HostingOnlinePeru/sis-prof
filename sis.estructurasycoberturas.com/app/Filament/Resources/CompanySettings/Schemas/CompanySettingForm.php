<?php

namespace App\Filament\Resources\CompanySettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanySettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos estáticos de la empresa')
                    ->schema([
                        TextInput::make('business_name')
                            ->label('Razón social')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('commercial_name')
                            ->label('Nombre comercial')
                            ->maxLength(255),
                        TextInput::make('tax_id')
                            ->label('RUC')
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
                        TextInput::make('website')
                            ->label('Web')
                            ->maxLength(255),
                        FileUpload::make('logo_path')
                            ->label('Logo general')
                            ->disk('public')
                            ->directory('company/logos')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp', 'image/svg+xml', 'image/svg'])
                            ->image(),
                        FileUpload::make('dashboard_logo_path')
                            ->label('Logo de plataforma / dashboard')
                            ->disk('public')
                            ->directory('company/logos')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp', 'image/svg+xml', 'image/svg'])
                            ->image(),
                        FileUpload::make('proforma_logo_path')
                            ->label('Logo para proformas y PDFs')
                            ->disk('public')
                            ->directory('company/logos')
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/webp', 'image/svg+xml', 'image/svg'])
                            ->image(),
                        Textarea::make('default_terms')
                            ->label('Términos por defecto')
                            ->rows(6)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
