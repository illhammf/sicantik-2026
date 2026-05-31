<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PesananResource\Pages;
use App\Models\Pesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesanan')
                    ->description('Kelola data pesanan catering dari pelanggan.')
                    ->schema([
                        Forms\Components\Select::make('pelanggan_id')
                            ->label('Nama Pelanggan')
                            ->relationship('pelanggan', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_pesanan')
                            ->label('Tanggal Pesanan')
                            ->default(now())
                            ->required(),

                        Forms\Components\DatePicker::make('tanggal_acara')
                            ->label('Tanggal Acara')
                            ->required(),

                        Forms\Components\TextInput::make('total_harga')
                            ->label('Total Harga')
                            ->prefix('Rp')
                            ->numeric()
                            ->default(0)
                            ->required(),

                        Forms\Components\Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'Menunggu' => 'Menunggu',
                                'Diproses' => 'Diproses',
                                'Dikirim' => 'Dikirim',
                                'Selesai' => 'Selesai',
                                'Dibatalkan' => 'Dibatalkan',
                            ])
                            ->default('Menunggu')
                            ->required(),

                        Forms\Components\Textarea::make('alamat_pengiriman')
                            ->label('Alamat Pengiriman')
                            ->placeholder('Masukkan alamat lengkap pengiriman')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Contoh: Tidak pedas, dikirim sebelum jam 10 pagi')
                            ->rows(3)
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

                Tables\Columns\TextColumn::make('tanggal_pesanan')
                    ->label('Tanggal Pesanan')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_acara')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'warning',
                        'Diproses' => 'info',
                        'Dikirim' => 'primary',
                        'Selesai' => 'success',
                        'Dibatalkan' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('alamat_pengiriman')
                    ->label('Alamat Pengiriman')
                    ->limit(40)
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('detail_pesanans_count')
                    ->label('Jumlah Item')
                    ->counts('detailPesanans')
                    ->badge()
                    ->sortable(),

                Tables\Columns\TextColumn::make('pembayarans_count')
                    ->label('Pembayaran')
                    ->counts('pembayarans')
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
            ->defaultSort('tanggal_pesanan', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diproses' => 'Diproses',
                        'Dikirim' => 'Dikirim',
                        'Selesai' => 'Selesai',
                        'Dibatalkan' => 'Dibatalkan',
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
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'view' => Pages\ViewPesanan::route('/{record}'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}