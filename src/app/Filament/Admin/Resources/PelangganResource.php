<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PelangganResource\Pages;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Pelanggan';

    protected static ?string $modelLabel = 'Pelanggan';

    protected static ?string $pluralModelLabel = 'Pelanggan';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pelanggan')
                    ->description('Kelola data pelanggan yang melakukan pemesanan catering.')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Pelanggan')
                            ->placeholder('Contoh: Ilham Firmansyah')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Contoh: pelanggan@gmail.com')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('no_hp')
                            ->label('Nomor HP')
                            ->placeholder('Contoh: 081234567890')
                            ->tel()
                            ->required()
                            ->maxLength(20),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat lengkap pelanggan')
                            ->required()
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
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email berhasil disalin'),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor HP')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor HP berhasil disalin'),

                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(40)
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('pesanans_count')
                    ->label('Jumlah Pesanan')
                    ->counts('pesanans')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('ulasans_count')
                    ->label('Jumlah Ulasan')
                    ->counts('ulasans')
                    ->badge()
                    ->sortable(),

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
            ->defaultSort('nama', 'asc')
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'view' => Pages\ViewPelanggan::route('/{record}'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}