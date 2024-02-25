<?php

namespace Jaymeh\FilamentPages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Jaymeh\FilamentDynamicBuilder\Services\BlockRenderer;
use Jaymeh\FilamentPages\Models\Page;
use Jaymeh\FilamentPages\Repositories\PageRepository;

class PagesController extends Controller
{
    public function __construct(protected BlockRenderer $blockRenderer, protected PageRepository $pageRepository)
    {
    }

    public function home()
    {
        $page = $this->pageRepository->published()->firstWhere('is_homepage', 1);

        if (! $page) {
            abort(404);
        }

        return $this->render($page);
    }

    public function show(Request $request)
    {
        $page = $this->pageRepository->published()->firstWhere('permalink', $request->path());
        if (! $page) {
            abort(404);
        }

        if ($page->is_homepage) {
            abort(404);
        }

        return $this->render($page);
    }

    protected function render(Page $page)
    {
        $content = $this->blockRenderer->render($page->content);

        return view(
            'filament-pages::page',
            [
                'title' => $page->title,
                'description' => $page->description,
                'content' => $content,
            ]
        );
    }
}
