<?php

namespace Jaymeh\FilamentPages\Filament\Resources;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Jaymeh\FilamentDynamicBuilder\Forms\Components\PageBuilder;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\CreatePage;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\EditPage;
use Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages\ListPages;

class PageResource extends Resource
{
    protected static ?string $model = \Jaymeh\FilamentPages\Models\Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Pages';

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
                        Section::make('General')
                            ->schema([
                                TextInput::make('title')
                                    ->live()
                                    ->required()
                                    ->rules('max:255')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state, ?Model $record) {
                                        if (! $get('permalink') && ! $record->isPublished()) {
                                            $set('permalink', Str::slug($state));
                                        }
                                    }),
                                TextArea::make('description')
                                    ->rules([])
                                    ->required(),
                                PageBuilder::make('content')
                                    ->label('Content')
                                    ->collapsible()
                                    ->required()
                                    ->rules(['required'])
                                    ->columnSpanFull()
                                    ->blockNumbers(false),
                            ])->columnSpan([
                                'md' => 2,
                                'lg' => 4,
                                'xl' => 4,
                                '2xl' => 6,
                            ]),
                        Section::make('Page Settings')
                            ->schema([
                                Toggle::make('published_at')
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->live(onBlur: true)
                                    ->label(function (Get $get) {
                                        return $get('published_at') ? 'Published' : 'Unpublished';
                                    })
                                    ->dehydrateStateUsing(function (?Model $record, ?string $state) {
                                        if (! $state) {
                                            return null;
                                        }

                                        if ($record->isPublished() && $state) {
                                            return $record->published_at;
                                        }

                                        return now();
                                    }),
                                Checkbox::make('is_homepage')
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        if ($state) {
                                            $set('permalink', null);
                                        }
                                    }),
                                TextInput::make('permalink')
                                    ->required(fn (Get $get) => $get('is_homepage') === false)
                                    ->rules(['nullable', 'required_if:is_homepage,0', 'max:255'])
                                    ->hidden(fn (Get $get): bool => $get('is_homepage'))
                                    ->helperText(
                                        'The URL of the page.'
                                    ),
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
                IconColumn::make('published_at')
                    ->boolean()
                    ->default(false)
                    ->label('Published')
                    ->icon(function ($record, ?string $state) {
                        return $record->isPublished() ? 'heroicon-s-check-circle' : 'heroicon-s-x-circle';
                    })
                    ->color(fn ($record) => $record->isPublished() ? 'success' : 'danger')
                    ->alignCenter()
                    ->sortable(),
                IconColumn::make('is_homepage')
                    ->boolean()
                    ->icon('heroicon-s-home')
                    ->color(fn ($record) => $record->is_homepage ? 'success' : 'danger')
                    ->alignCenter(),
                TextColumn::make('title')
                    ->sortable(),
                TextColumn::make('permalink'),
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
        return config('filament-pages.pages_model', static::$model);
    }
}
