<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KategoriMenuResource\Pages;
use App\Models\KategoriMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KategoriMenuResource extends Resource
{
    protected static ?string $model = KategoriMenu::class;

    protected static ?string $navigationIcon = 'heroicon-s-tag';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Kategori Menu';

    protected static ?string $modelLabel = 'Kategori Menu';

    protected static ?string $pluralModelLabel = 'Kategori Menu';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Kategori Menu')
                    ->description('Kelola kategori menu catering seperti nasi box, prasmanan, snack box, dan lainnya.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_kategori')
                            ->label('Nama Kategori')
                            ->placeholder('Contoh: Nasi Box')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan deskripsi singkat kategori menu')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('menus_count')
                    ->label('Jumlah Menu')
                    ->counts('menus')
                    ->sortable()
                    ->badge(),

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
            ->defaultSort('nama_kategori', 'asc')
            ->filters([
                //
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
            'index' => Pages\ListKategoriMenus::route('/'),
            'create' => Pages\CreateKategoriMenu::route('/create'),
            'view' => Pages\ViewKategoriMenu::route('/{record}'),
            'edit' => Pages\EditKategoriMenu::route('/{record}/edit'),
        ];
    }
}