<?php

namespace App\Filament\Pages;

use App\Models\LegalContent;
use BackedEnum;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageLegalContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-legal-content';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Kebijakan & Ketentuan';

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(LegalContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kebijakan Privasi')
                    ->schema([
                        RichEditor::make('privacy_policy')
                            ->label('')
                            ->columnSpanFull(),
                    ]),
                Section::make('Syarat & Ketentuan')
                    ->schema([
                        RichEditor::make('terms_conditions')
                            ->label('')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        LegalContent::current()->update($this->form->getState());

        Notification::make()
            ->title('Kebijakan & ketentuan berhasil disimpan')
            ->success()
            ->send();
    }
}
