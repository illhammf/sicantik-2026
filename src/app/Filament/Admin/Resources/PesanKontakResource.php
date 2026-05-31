<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PesanKontakResource\Pages;
use App\Models\PesanKontak;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PesanKontakResource extends Resource
{
    protected static ?string $model = PesanKontak::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Manajemen Catering';

    protected static ?string $navigationLabel = 'Pesan Kontak';

    protected static ?string $modelLabel = 'Pesan Kontak';

    protected static ?string $pluralModelLabel = 'Pesan Kontak';

    protected static ?int $navigationSort = 8;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pesan Kontak')
                    ->description('Kelola pesan yang dikirim pengunjung melalui form kontak website.')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Pengirim')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subjek')
                            ->label('Subjek')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('status')
                            ->label('Status Pesan')
                            ->options([
                                'Belum Dibaca' => 'Belum Dibaca',
                                'Sudah Dibaca' => 'Sudah Dibaca',
                            ])
                            ->default('Belum Dibaca')
                            ->required(),

                        Forms\Components\Textarea::make('pesan')
                            ->label('Isi Pesan')
                            ->required()
                            ->rows(5)
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
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email berhasil disalin'),

                Tables\Columns\TextColumn::make('subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->sortable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('pesan')
                    ->label('Pesan')
                    ->limit(45)
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Belum Dibaca' => 'warning',
                        'Sudah Dibaca' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dikirim Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'Belum Dibaca' => 'Belum Dibaca',
                        'Sudah Dibaca' => 'Sudah Dibaca',
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
            'index' => Pages\ListPesanKontaks::route('/'),
            'create' => Pages\CreatePesanKontak::route('/create'),
            'view' => Pages\ViewPesanKontak::route('/{record}'),
            'edit' => Pages\EditPesanKontak::route('/{record}/edit'),
        ];
    }
}