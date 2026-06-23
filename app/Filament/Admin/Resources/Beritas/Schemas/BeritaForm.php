<?php

namespace App\Filament\Admin\Resources\Beritas\Schemas;

use App\Models\Company;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BeritaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konten Berita')
                    ->columns(1)
                    ->components([
                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Otomatis terisi dari judul, bisa diedit manual kalau perlu.'),

                        RichEditor::make('konten')
                            ->required()
                            ->columnSpanFull(),

                        FileUpload::make('thumbnail')
                            ->label('Gambar Thumbnail')
                            ->image()
                            ->directory('berita')
                            ->disk('public')
                            ->imageEditor()
                            ->maxSize(2048),
                    ]),

                Section::make('Kategori & Status')
                    ->columns(2)
                    ->components([
                        Select::make('kategori')
                            ->options([
                                'umum' => 'Umum',
                                'berita' => 'Berita',
                                'tips-karir' => 'Tips Karir',
                                'berita-perusahaan' => 'Berita Perusahaan',
                            ])
                            ->default('umum')
                            ->required(),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'pending' => 'Pending',
                            ])
                            ->default('draft')
                            ->required()
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->helperText('Kosongkan untuk pakai waktu saat ini saat status Published.'),

                        TextInput::make('views')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ]),

                Section::make('Sponsor (Opsional)')
                    ->columns(2)
                    ->components([
                        Select::make('company_id')
                            ->label('Perusahaan')
                            ->options(fn () => Company::pluck('company_name', 'id'))
                            ->searchable()
                            ->nullable(),

                        Toggle::make('is_sponsored')
                            ->label('Berita Sponsor')
                            ->live()
                            ->default(false),

                        TextInput::make('harga_sponsor')
                            ->label('Nominal Sponsor (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->visible(fn (callable $get) => $get('is_sponsored')),
                    ]),
            ]);
    }
}
