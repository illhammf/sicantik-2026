<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?string $pluralModelLabel = 'Pembayaran';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pembayaran')
                    ->description('Kelola data pembayaran pesanan catering.')
                    ->schema([
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

                        Forms\Components\Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options([
                                'Transfer Bank' => 'Transfer Bank',
                                'QRIS' => 'QRIS',
                                'Tunai' => 'Tunai',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('jumlah_bayar')
                            ->label('Jumlah Bayar')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Pembayaran')
                            ->options([
                                'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                                'Lunas' => 'Lunas',
                                'Ditolak' => 'Ditolak',
                            ])
                            ->default('Menunggu Verifikasi')
                            ->required(),

                        Forms\Components\TextInput::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->placeholder('Contoh: bukti-transfer.jpg')
                            ->maxLength(255)
                            ->default(null)
                            ->columnSpanFull(),
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

                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah_bayar')
                    ->label('Jumlah Bayar')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu Verifikasi' => 'warning',
                        'Lunas' => 'success',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('bukti_pembayaran')
                    ->label('Bukti Pembayaran')
                    ->searchable()
                    ->placeholder('Belum Ada')
                    ->toggleable(),

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
                Tables\Filters\SelectFilter::make('metode_pembayaran')
                    ->label('Filter Metode')
                    ->options([
                        'Transfer Bank' => 'Transfer Bank',
                        'QRIS' => 'QRIS',
                        'Tunai' => 'Tunai',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi',
                        'Lunas' => 'Lunas',
                        'Ditolak' => 'Ditolak',
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
            'index' => Pages\ListPembayarans::route('/'),
            'create' => Pages\CreatePembayaran::route('/create'),
            'view' => Pages\ViewPembayaran::route('/{record}'),
            'edit' => Pages\EditPembayaran::route('/{record}/edit'),
        ];
    }
}