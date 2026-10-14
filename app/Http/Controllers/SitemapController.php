<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Announcement;
use App\Models\KbArticle;
class SitemapController extends Controller {
    public function index() {
        $urls = [
            ['loc' => url('/'), 'priority' => '1.0'],
            ['loc' => url('/kb'), 'priority' => '0.8'],
            ['loc' => url('/announcements'), 'priority' => '0.7'],
        ];
        foreach (Product::where('is_active',true)->get() as $p) {
            $urls[] = ['loc' => url('/products'), 'priority' => '0.6'];
        }
        foreach (Announcement::latest()->limit(50)->get() as $a) {
            $urls[] = ['loc' => url('/announcements/'.$a->id), 'priority' => '0.5'];
        }
        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
