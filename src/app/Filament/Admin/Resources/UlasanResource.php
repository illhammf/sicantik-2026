<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UlasanResource\Pages;
use App\Models\Ulasan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UlasanResource extends Resource
{
    protected static ?string $model = Ulasan::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Ulasan';

    protected static ?string $modelLabel = 'Ulasan';

    protected static ?string $pluralModelLabel = 'Ulasan';

    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Ulasan')
                    ->description('Kelola ulasan pelanggan terhadap pesanan catering.')
                    ->schema([
                        Forms\Components\Select::make('pelanggan_id')
                            ->label('Nama Pelanggan')
                            ->relationship('pelanggan', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('pesanan_id')
                            ->label('Pesanan')
                            ->relationship(
                                name: 'pesanan',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn ($query) => $query->with('pelanggan')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                ($record->pelanggan?->nama ?? 'Tanpa Nama') . ' - Acara ' . $record->tanggal_acara
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 - Sangat Kurang',
                                2 => '2 - Kurang',
                                3 => '3 - Cukup',
                                4 => '4 - Baik',
                                5 => '5 - Sangat Baik',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('komentar')
                            ->label('Komentar')
                            ->placeholder('Masukkan komentar pelanggan')
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
                Tables\Columns\TextColumn::make('pelanggan.nama')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pesanan.tanggal_acara')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->badge()
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('komentar')
                    ->label('Komentar')
                    ->limit(50)
                    ->searchable()
                    ->placeholder('-'),

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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Filter Rating')
                    ->options([
                        1 => '1 Bintang',
                        2 => '2 Bintang',
                        3 => '3 Bintang',
                        4 => '4 Bintang',
                        5 => '5 Bintang',
                    ]),

                Tables\Filters\SelectFilter::make('pelanggan_id')
                    ->label('Filter Pelanggan')
                    ->relationship('pelanggan', 'nama')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListUlasans::route('/'),
            'create' => Pages\CreateUlasan::route('/create'),
            'view' => Pages\ViewUlasan::route('/{record}'),
            'edit' => Pages\EditUlasan::route('/{record}/edit'),
        ];
    }
}