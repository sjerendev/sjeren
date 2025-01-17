<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Notifications\Notification;

class ManageSettings extends SettingsPage
{
	protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
	protected static ?string $navigationLabel = 'Settings';
	protected static ?string $title = 'Studio Settings';
	protected static ?int $navigationSort = 100;
	protected static string $settings = GeneralSettings::class;

	public static function getNavigationGroup(): ?string
	{
		return null;
	}

	public function form(Form $form): Form
	{
		return $form->schema([
			Forms\Components\Section::make('Basic Information')
				->schema([
					Forms\Components\TextInput::make('site_name')
						->required(),
					Forms\Components\TextInput::make('tagline')
						->required(),
					Forms\Components\TextInput::make('email')
						->email(),
					Forms\Components\TextInput::make('phone')
						->tel(),
					Forms\Components\Textarea::make('address')
				]),

			Forms\Components\Section::make('Branding')
				->schema([
					Forms\Components\FileUpload::make('logo')
						->image()
						->directory('branding'),
					Forms\Components\FileUpload::make('favicon')
						->image()
						->directory('branding'),
				]),

			Forms\Components\Section::make('Social Media')
				->schema([
					Forms\Components\TextInput::make('facebook_url')
						->url()
						->prefix('https://')
						->placeholder('facebook.com/your-page'),
					Forms\Components\TextInput::make('instagram_url')
						->url()
						->prefix('https://')
						->placeholder('instagram.com/your-handle'),
					Forms\Components\TextInput::make('linkedin_url')
						->url()
						->prefix('https://')
						->placeholder('linkedin.com/company/your-company'),
				]),
			Forms\Components\Section::make('Navigation Settings')
				->schema([
					Forms\Components\Select::make('navigation_type')
						->options([
							'normal' => 'Normal Menu (Hamburger on Mobile)',
							'hamburger' => 'Always Hamburger Menu',
						])
						->required()
						->live(),
					Forms\Components\Grid::make(2)
						->schema([
							Forms\Components\Toggle::make('show_contact_in_menu')
								->visible(fn(Forms\Get $get) => $get('navigation_type') === 'hamburger'),
							Forms\Components\Toggle::make('show_social_in_menu')
								->visible(fn(Forms\Get $get) => $get('navigation_type') === 'hamburger'),
						]),
					Forms\Components\RichEditor::make('menu_contact_info')
						->visible(
							fn(Forms\Get $get) =>
							$get('navigation_type') === 'hamburger' &&
								$get('show_contact_in_menu')
						)
						->columnSpanFull(),
				]),

		]);
	}

	protected function afterSave(): void
	{
		Notification::make()
			->title('Settings saved successfully')
			->success()
			->send();
	}
}
