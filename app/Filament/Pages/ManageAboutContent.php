<?php

namespace App\Filament\Pages;

use App\Models\AboutContent;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageAboutContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-about-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Konten About Us';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(AboutContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('hero_headline')
                            ->required()
                            ->helperText('Apit kata dengan *bintang* untuk dicetak miring, contoh: unit yang *pas*.'),
                        Textarea::make('hero_subtext')
                            ->rows(3)
                            ->required(),
                    ]),
                Section::make('Latar Belakang (Bio)')
                    ->schema([
                        Textarea::make('bio_paragraph_1')->label('Paragraf 1')->rows(4)->required(),
                        Textarea::make('bio_paragraph_2')->label('Paragraf 2')->rows(4)->required(),
                    ]),
                Section::make('Kredensial')
                    ->columns(2)
                    ->schema([
                        TextInput::make('credential_afiliasi')->label('Afiliasi')->required(),
                        TextInput::make('credential_area')->label('Area operasi')->required(),
                        TextInput::make('credential_pengalaman')->label('Pengalaman')->required(),
                        TextInput::make('credential_kontak')->label('Kontak')->required(),
                    ]),
                Section::make('Tentang Agensi')
                    ->schema([
                        Textarea::make('linktown_description')
                            ->rows(4)
                            ->required()
                            ->helperText('Disclaimer di bawahnya tetap diambil dari menu Pengaturan, bukan dari sini.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        AboutContent::current()->update($this->form->getState());

        Notification::make()
            ->title('Konten About Us berhasil disimpan')
            ->success()
            ->send();
    }
}
