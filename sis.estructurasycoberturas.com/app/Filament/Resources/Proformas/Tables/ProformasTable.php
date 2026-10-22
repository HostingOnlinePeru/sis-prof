<?php

namespace App\Filament\Resources\Proformas\Tables;

use App\Models\Proforma;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProformasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')->label('Número')->searchable()->sortable(),
                TextColumn::make('client.name')->label('Cliente')->searchable()->sortable(),
                TextColumn::make('issue_date')->label('Fecha')->date()->sortable(),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'created' => 'Creada',
                        'sent' => 'Enviada',
                        'accepted' => 'Aceptada',
                        'cancelled' => 'Cancelada',
                        default => $state,
                    }),
                TextColumn::make('total')->label('Total')->money('PEN')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'created' => 'Creada',
                        'sent' => 'Enviada',
                        'accepted' => 'Aceptada',
                        'cancelled' => 'Cancelada',
                    ]),
            ])
            ->recordActions([
                Action::make('pdf')
                    ->label('PDF')
                    ->url(fn (Proforma $record): string => route('proformas.pdf', $record))
                    ->openUrlInNewTab(),
                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->url(fn (Proforma $record): string => $record->whatsappUrl())
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
