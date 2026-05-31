<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DetailPesananResource\Pages;
use App\Models\DetailPesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DetailPesananResource extends Resource
{
    protected static ?string $model = DetailPesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Detail Pesanan';

    protected static ?string $modelLabel = 'Detail Pesanan';

    protected static ?string $pluralModelLabel = 'Detail Pesanan';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Detail Pesanan')
                    ->description('Kelola item menu yang terdapat di dalam pesanan catering.')
                    ->schema([
                        Forms\Components\Select::make('pesanan_id')
                            ->label('Pesanan')
                            ->relationship(
                                name: 'pesanan',
                                titleAttribute: 'id',
                                modifyQueryUsing: fn ($query) => $query->with('pelanggan')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => 
                                $record->pelanggan?->nama . ' - Acara ' . optional($record->tanggal_acara)->format('d M Y')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('menu_id')
                            ->label('Menu')
                            ->relationship('menu', 'nama_menu')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->numeric()
                            ->minValue(1)
                            ->required(),

                        Forms\Components\TextInput::make('harga')
                            ->label('Harga Satuan')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pesanan.pelanggan.nama')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pesanan.tanggal_acara')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('menu.nama_menu')
                    ->label('Nama Menu')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('harga')
                    ->label('Harga Satuan')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('menu_id')
                    ->label('Filter Menu')
                    ->relationship('menu', 'nama_menu')
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
            'index' => Pages\ListDetailPesanans::route('/'),
            'create' => Pages\CreateDetailPesanan::route('/create'),
            'view' => Pages\ViewDetailPesanan::route('/{record}'),
            'edit' => Pages\EditDetailPesanan::route('/{record}/edit'),
        ];
    }
}