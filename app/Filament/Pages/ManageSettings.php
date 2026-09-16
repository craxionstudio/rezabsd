<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Pengaturan';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Sales & Agensi')
                    ->columns(2)
                    ->schema([
                        FileUpload::make('foto_profil')
                            ->image()
                            ->avatar()
                            ->disk('public')
                            ->directory('profil')
                            ->columnSpanFull(),
                        TextInput::make('nama_sales')->required(),
                        TextInput::make('jabatan')->required(),
                        TextInput::make('nama_agensi')->required(),
                        TextInput::make('alamat_agensi'),
                    ]),
                Section::make('Kontak')
                    ->columns(2)
                    ->schema([
                        TextInput::make('whatsapp')
                            ->tel()
                            ->helperText('Format: 62812xxxxxxx (tanpa tanda +)'),
                        TextInput::make('email')->email(),
                        TextInput::make('instagram'),
                        TextInput::make('facebook'),
                        TextInput::make('tiktok'),
                    ]),
                Section::make('Bio & Disclaimer')
                    ->schema([
                        Textarea::make('bio')
                            ->rows(4)
                            ->columnSpanFull(),
                        Textarea::make('disclaimer')
                            ->required()
                            ->rows(3)
                            ->helperText('Wajib tampil di halaman About Us — kanal pemasaran independen, bukan situs resmi developer/kawasan.')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::current()->update($this->form->getState());

        Notification::make()
            ->title('Pengaturan berhasil disimpan')
            ->success()
            ->send();
    }
}
