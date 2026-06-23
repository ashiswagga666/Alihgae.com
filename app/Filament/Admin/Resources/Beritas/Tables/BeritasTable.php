<?php

namespace App\Filament\Admin\Resources\Beritas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BeritasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(50),

                TextColumn::make('judul')
                    ->searchable()
                    ->limit(40)
                    ->weight('bold'),

                TextColumn::make('kategori')
                    ->badge()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'pending' => 'warning',
                        'draft' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('is_sponsored')
                    ->label('Sponsor')
                    ->badge()
                    ->formatStateUsing(fn (bool $state) => $state ? 'Ya' : 'Tidak')
                    ->color(fn (bool $state) => $state ? 'success' : 'gray'),

                TextColumn::make('views')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->dateTime('d M Y')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'pending' => 'Pending',
                    ]),
                SelectFilter::make('kategori')
                    ->options([
                        'umum' => 'Umum',
                        'berita' => 'Berita',
                        'tips-karir' => 'Tips Karir',
                        'berita-perusahaan' => 'Berita Perusahaan',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
