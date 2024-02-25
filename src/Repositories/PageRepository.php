<?php

namespace Jaymeh\FilamentPages\Repositories;

use Creode\LaravelRepository\BaseRepository;

class PageRepository extends BaseRepository
{
    /**
     * {@ineritdoc}
     */
    protected function getModel(): string
    {
        return config('pages.page_model', \Jaymeh\FilamentPages\Models\Page::class);
    }
}
