<?php

namespace App\Filament\Resources\Articles\Tables;

use App\Filament\Resources\Articles\ArticleResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->circular(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->limit(40)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('author')
                    ->label('Penulis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y | H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_published')
                    ->label('Status')
                    ->options([
                        1 => 'Published',
                        0 => 'Draft',
                    ]),
            ])
            ->recordUrl(null)
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

