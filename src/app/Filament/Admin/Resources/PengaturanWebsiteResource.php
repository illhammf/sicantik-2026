<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PengaturanWebsiteResource\Pages;
use App\Models\PengaturanWebsite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PengaturanWebsiteResource extends Resource
{
    protected static ?string $model = PengaturanWebsite::class;

    protected static ?string $navigationIcon = 'heroicon-s-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan Website';

    protected static ?string $navigationLabel = 'Pengaturan Website';

    protected static ?string $modelLabel = 'Pengaturan Website';

    protected static ?string $pluralModelLabel = 'Pengaturan Website';

    protected static ?int $navigationSort = 99;

    public static function canCreate(): bool
    {
        return PengaturanWebsite::count() === 0;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Website')
                    ->description('Atur identitas utama website SiCantik Catering.')
                    ->schema([
                        Forms\Components\TextInput::make('nama_website')
                            ->label('Nama Website')
                            ->placeholder('Contoh: SiCantik Catering')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Website')
                            ->image()
                            ->imageEditor()
                            ->directory('pengaturan/logo')
                            ->visibility('public'),

                        Forms\Components\FileUpload::make('favicon')
                            ->label('Favicon Website')
                            ->image()
                            ->imageEditor()
                            ->directory('pengaturan/favicon')
                            ->visibility('public'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Hero Section')
                    ->description('Atur tampilan utama yang muncul di bagian paling atas website.')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar_hero')
                            ->label('Gambar Hero')
                            ->image()
                            ->imageEditor()
                            ->directory('pengaturan/hero')
                            ->visibility('public')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('badge_hero')
                            ->label('Badge Hero')
                            ->placeholder('Contoh: Catering Lezat Untuk Setiap Acara')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('judul_hero')
                            ->label('Judul Hero')
                            ->placeholder('Contoh: Solusi Catering Praktis, Enak, dan Terpercaya')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('deskripsi_hero')
                            ->label('Deskripsi Hero')
                            ->placeholder('Masukkan deskripsi singkat tentang SiCantik Catering')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Kontak Website')
                    ->description('Atur informasi kontak yang tampil di bagian kontak website.')
                    ->schema([
                        Forms\Components\TextInput::make('judul_kontak')
                            ->label('Judul Kontak')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('no_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('alamat')
                            ->label('Alamat')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('deskripsi_kontak')
                            ->label('Deskripsi Kontak')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Media Sosial')
                    ->description('Masukkan link media sosial atau kontak resmi SiCantik Catering.')
                    ->schema([
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->placeholder('https://instagram.com/sicantikcatering')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->placeholder('https://facebook.com/sicantikcatering')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url()
                            ->placeholder('https://tiktok.com/@sicantikcatering')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->placeholder('https://youtube.com/@sicantikcatering')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('whatsapp')
                            ->label('WhatsApp')
                            ->url()
                            ->placeholder('https://wa.me/6281234567890')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Footer')
                    ->description('Atur teks footer yang tampil di bagian bawah website.')
                    ->schema([
                        Forms\Components\Textarea::make('footer')
                            ->label('Teks Footer')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),

                Tables\Columns\TextColumn::make('nama_website')
                    ->label('Nama Website')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor HP')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('judul_hero')
                    ->label('Judul Hero')
                    ->limit(35)
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
            'index' => Pages\ListPengaturanWebsites::route('/'),
            'create' => Pages\CreatePengaturanWebsite::route('/create'),
            'view' => Pages\ViewPengaturanWebsite::route('/{record}'),
            'edit' => Pages\EditPengaturanWebsite::route('/{record}/edit'),
        ];
    }
}