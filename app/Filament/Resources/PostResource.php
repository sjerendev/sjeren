<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\BaseContentSection;
use App\Filament\Forms\Components\ContentBlocksSection;
use App\Filament\Forms\Components\HeroSection;
use App\Filament\Forms\Components\PostSettingsSection;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->columnSpan('full')
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                BaseContentSection::make()
                                    ->heading('Basic Information'),
                            ]),
                        Forms\Components\Group::make()
                            ->schema([
                                PostSettingsSection::make(),
                            ]),
                    ]),
                Forms\Components\Group::make()
                    ->columnSpan('full')
                    ->schema([
                        HeroSection::make(),
                        ContentBlocksSection::make(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('categories.name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('publish_date')
                    ->dateTime()
                    ->sortable()
                    ->default(fn ($record) => $record->created_at),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}