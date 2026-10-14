<?php
namespace App\Http\Controllers;
use App\Models\KbCategory;
use App\Models\KbArticle;
class HelpController extends Controller {
    public function index() {
        $categories = KbCategory::withCount('articles')->get();
        $popular = KbArticle::latest()->limit(6)->get();
        return view('help.index', compact('categories', 'popular'));
    }
    public function category(KbCategory $category) {
        $articles = KbArticle::where('kb_category_id', $category->id)->latest()->paginate(20);
        return view('help.category', compact('category', 'articles'));
    }
    public function article(KbArticle $article) {
        $related = KbArticle::where('kb_category_id', $article->kb_category_id)
            ->where('id', '!=', $article->id)
            ->limit(5)->get();
        return view('help.article', compact('article', 'related'));
    }
}
