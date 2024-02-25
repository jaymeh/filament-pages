<?php

namespace Jaymeh\FilamentPages\Filament\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Component;
use Filament\Resources\Pages\EditRecord;
use Jaymeh\FilamentDynamicBuilder\Forms\Components\PageBuilder;
use Jaymeh\FilamentPages\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getBuilderPreviewView(string $builderName): ?string
    {
        // This corresponds to resources/views/posts/preview-blocks.blade.php
        return 'posts.preview-blocks';
    }

    public static function getBuilderEditorSchema(string $builderName): Component | array
    {
        return PageBuilder::make('content');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
