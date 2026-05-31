<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DetailPesananResource\Pages;
use App\Filament\Admin\Resources\DetailPesananResource\RelationManagers;
use App\Models\DetailPesanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailPesananResource extends Resource
{
    protected static ?string $model = DetailPesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('pesanan_id')
                    ->relationship('pesanan', 'id')
                    ->required(),
                Forms\Components\Select::make('menu_id')
                    ->relationship('menu', 'id')
                    ->required(),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('harga')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('subtotal')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pesanan.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('menu.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('harga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'edit' => Pages\EditDetailPesanan::route('/{record}/edit'),
        ];
    }
}
