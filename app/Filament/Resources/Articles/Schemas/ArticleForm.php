<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Artikel')
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if (blank($state)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->hint('Slug otomatis mengikuti judul.')
                            ->maxLength(255),
                        TextInput::make('author')
                            ->label('Penulis')
                            ->required()
                            ->maxLength(150),
                        Textarea::make('summary')
                            ->label('Ringkasan')
                            ->rows(3)
                            ->maxLength(400)
                            ->helperText('Ditampilkan di kartu artikel.'),
                        FileUpload::make('thumbnail_path')
                            ->label('Thumbnail')
                            ->disk('public')
                            ->directory('articles-thumbnails')
                            ->image()
                            ->imageEditor()
                            ->visibility('public')
                            ->imageEditorAspectRatios(['16:9', '4:3', '1:1'])
                            ->maxSize(4096),
                        RichEditor::make('content')
                            ->label('Konten')
                            ->columnSpanFull()
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('articles-media')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'strike',
                                'bulletList',
                                'orderedList',
                                'link',
                                'blockquote',
                                'codeBlock',
                                'table',
                                'attachFiles',
                                'undo',
                                'redo',
                            ])
                            ->disableToolbarButtons([
                                'code',
                            ]),
                    ])
                    ->columns(2),
                Section::make('Publikasi')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publish sekarang?')
                            ->live()
                            ->helperText('Nonaktifkan jika ingin simpan sebagai draft.'),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->seconds(false)
                            ->visible(fn (Get $get): bool => (bool) $get('is_published'))
                            ->required(fn (Get $get): bool => (bool) $get('is_published')),
                    ])
                    ->columns(2),
            ]);
    }
}

