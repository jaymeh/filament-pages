<?php

namespace Jaymeh\FilamentPages\Filament\Resources;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Jaymeh\FilamentDynamicBuilder\Forms\Components\PageBuilder;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\CreatePage;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\EditPage;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\ListPages;

class PageResource extends Resource
{
    protected static ?string $model = \Jaymeh\FilamentPages\Models\Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                    'sm' => 2,
                    'md' => 3,
                    'lg' => 4,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                    ->schema([
                        Section::make('General')->schema([
                            TextInput::make('title')
                                ->live()
                                ->required()
                                ->rules('max:255')
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                    if (! $get('permalink')) {
                                        $set('permalink', Str::slug($state));
                                    }
                                }),
                            TextArea::make('description')
                                ->rules([])
                                ->required(),
                            PageBuilder::make('content')
                                ->label('Content')
                                ->collapsible()
                                ->rules(['required'])
                                ->columnSpanFull()
                                ->blockNumbers(false),
                        ])->columnSpan([
                            'md' => 2,
                            'lg' => 4,
                            'xl' => 4,
                            '2xl' => 6,
                        ]),
                        Section::make('Url Settings')->schema([
                            Checkbox::make('is_homepage')
                                ->live(),
                            TextInput::make('permalink')
                                ->required()
                                ->rules(['nullable', 'max:255'])
                                ->disabled(fn (Get $get): bool => $get('is_homepage')),
                        ])->columnSpan([
                            'md' => 1,
                            'lg' => 4,
                            'xl' => 2,
                            '2xl' => 2,
                        ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }

    public static function getModel(): string
    {
        return config('pages.pages_model', static::$model);
    }
}
