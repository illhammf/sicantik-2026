<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-s-cake';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Menu Catering';

    protected static ?string $modelLabel = 'Menu';

    protected static ?string $pluralModelLabel = 'Menu Catering';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Menu Catering')
                    ->description('Kelola data menu catering berdasarkan kategori, harga, gambar, dan status ketersediaan.')
                    ->schema([
                        Forms\Components\Select::make('kategori_menu_id')
                            ->label('Kategori Menu')
                            ->relationship('kategoriMenu', 'nama_kategori')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('nama_menu')
                            ->label('Nama Menu')
                            ->placeholder('Contoh: Nasi Box Ayam Bakar')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'Tersedia' => 'Tersedia',
                                'Tidak Tersedia' => 'Tidak Tersedia',
                            ])
                            ->default('Tersedia')
                            ->required(),

                        Forms\Components\FileUpload::make('gambar')
                            ->label('Gambar Menu')
                            ->image()
                            ->imageEditor()
                            ->directory('menu')
                            ->disk('public')
                            ->visibility('public')
                            ->nullable()
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan deskripsi menu catering')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kategoriMenu.nama_kategori')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('nama_menu')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Tersedia' => 'success',
                        'Tidak Tersedia' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(40)
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(60)
                    ->width(60)
                    ->circular(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nama_menu', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_menu_id')
                    ->label('Filter Kategori')
                    ->relationship('kategoriMenu', 'nama_kategori')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Tidak Tersedia' => 'Tidak Tersedia',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Lihat'),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus Terpilih'),
                ]),
            ]);
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'view' => Pages\ViewMenu::route('/{record}'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}