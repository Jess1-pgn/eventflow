<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $events = Event::query()
            ->where('status', Event::STATUS_PUBLISHED)
            ->select(['seo_slug', 'updated_at'])
            ->latest('updated_at')
            ->get();

        $content = view('sitemap', ['events' => $events])->render();

        return response($content)
            ->header('Content-Type', 'application/xml');
    }
}
