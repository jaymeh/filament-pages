<?php

namespace Jaymeh\FilamentPages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jaymeh\FilamentDynamicBuilder\Traits\HasComponents;
use PawelMysior\Publishable\Publishable;

class Page extends Model
{
    use HasComponents;
    use HasFactory;
    use Publishable;

    /**
     * Sets table property so that extended models don't need to define it.
     *
     * @var string
     */
    protected $table = 'pages';

    protected $fillable = [
        'is_homepage',
        'permalink',
        'title',
        'description',
        'content',
        'published_at',
    ];

    protected $casts = [
        'content' => 'array',
    ];
}
