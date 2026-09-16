<?php

namespace App\Filament\Pages;

use App\Models\HomeContent;
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

class ManageHomeContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-home-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Konten Home';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(HomeContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Hero')
                    ->schema([
                        TextInput::make('hero_eyebrow')
                            ->label('Eyebrow (teks kecil di atas judul)')
                            ->required(),
                        TextInput::make('hero_headline')
                            ->required()
                            ->helperText('Apit kata dengan *bintang* untuk dicetak miring, contoh: Terasa seperti *pulang*.'),
                        Textarea::make('hero_subtext')
                            ->rows(3)
                            ->required(),
                        TextInput::make('hero_cta_label')
                            ->label('Label tombol CTA hero')
                            ->required(),
                    ]),
                Section::make('Statistik')
                    ->columns(3)
                    ->schema([
                        TextInput::make('stat_1_value')->label('Angka 1')->required(),
                        TextInput::make('stat_1_label')->label('Label 1')->required(),
                        TextInput::make('stat_2_value')->label('Angka 2')->required(),
                        TextInput::make('stat_2_label')->label('Label 2')->required(),
                        TextInput::make('stat_3_value')->label('Angka 3')->required(),
                        TextInput::make('stat_3_label')->label('Label 3')->required(),
                    ]),
                Section::make('Proses (3 langkah)')
                    ->schema([
                        TextInput::make('process_step_1_title')->label('Judul langkah 1')->required(),
                        Textarea::make('process_step_1_desc')->label('Deskripsi langkah 1')->rows(2)->required(),
                        TextInput::make('process_step_2_title')->label('Judul langkah 2')->required(),
                        Textarea::make('process_step_2_desc')->label('Deskripsi langkah 2')->rows(2)->required(),
                        TextInput::make('process_step_3_title')->label('Judul langkah 3')->required(),
                        Textarea::make('process_step_3_desc')->label('Deskripsi langkah 3')->rows(2)->required(),
                    ]),
                Section::make('Testimoni')
                    ->schema([
                        Textarea::make('testimonial_quote')->rows(2)->required(),
                        TextInput::make('testimonial_name')->required(),
                    ]),
                Section::make('CTA Banner (sebelum footer)')
                    ->schema([
                        TextInput::make('cta_banner_title')->required(),
                        Textarea::make('cta_banner_subtitle')->rows(2)->required(),
                        TextInput::make('cta_banner_button_label')->required(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        HomeContent::current()->update($this->form->getState());

        Notification::make()
            ->title('Konten Home berhasil disimpan')
            ->success()
            ->send();
    }
}
