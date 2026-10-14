<?php
namespace App\Http\Controllers;
use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Http\Request;
class KbController extends Controller {
    public function index(Request $request) {
        $categories = KbCategory::withCount('articles')->orderBy('sort')->get();
        $q = $request->input('q');
        $articles = KbArticle::where('is_published',true)
            ->when($q, fn($query) => $query->where('title','like',"%{$q}%"))
            ->latest()->paginate(12);
        return view('kb.index', compact('categories','articles','q'));
    }
    public function category(KbCategory $category) {
        $articles = KbArticle::where('category_id',$category->id)->where('is_published',true)->latest()->paginate(12);
        return view('kb.category', compact('category','articles'));
    }
    public function show(KbArticle $article) {
        $article->increment('views');
        return view('kb.show', compact('article'));
    }
}
