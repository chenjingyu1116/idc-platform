<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\KbArticle;
use App\Models\Announcement;
use Illuminate\Http\Request;
class SearchController extends Controller {
    public function index(Request $request) {
        $q = trim($request->input('q', ''));
        $products = $articles = $announcements = collect();

        if ($q !== '') {
            $products = Product::where('is_active', true)
                ->where(function($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                })->limit(10)->get();

            $articles = KbArticle::where('title', 'like', "%{$q}%")
                ->orWhere('content', 'like', "%{$q}%")
                ->limit(10)->get();

            $announcements = Announcement::where('title', 'like', "%{$q}%")
                ->orWhere('content', 'like', "%{$q}%")
                ->limit(10)->get();
        }

        return view('search', compact('q', 'products', 'articles', 'announcements'));
    }
}
