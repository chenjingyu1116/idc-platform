<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KbArticle;
use App\Models\KbCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class KbController extends Controller {
    public function index() {
        $categories = KbCategory::withCount('articles')->orderBy('sort')->get();
        $articles = KbArticle::with('category')->latest()->paginate(20);
        return view('admin.kb.index', compact('categories','articles'));
    }
    public function createCategory() { return view('admin.kb.create-category'); }
    public function storeCategory(Request $request) {
        $v = $request->validate(['name'=>'required|string','description'=>'nullable|string','sort'=>'integer']);
        KbCategory::create(['name'=>$v['name'],'slug'=>Str::slug($v['name']).'-'.Str::random(4),'description'=>$v['description'] ?? null,'sort'=>$v['sort'] ?? 0]);
        return redirect()->route('admin.kb.index')->with('success','分类已添加');
    }
    public function createArticle() {
        $categories = KbCategory::orderBy('sort')->get();
        return view('admin.kb.create-article', compact('categories'));
    }
    public function storeArticle(Request $request) {
        $v = $request->validate(['category_id'=>'required|exists:kb_categories,id','title'=>'required|string','content'=>'required|string']);
        KbArticle::create(['category_id'=>$v['category_id'],'title'=>$v['title'],'slug'=>Str::slug($v['title']).'-'.Str::random(4),'content'=>$v['content'],'is_published'=>true]);
        return redirect()->route('admin.kb.index')->with('success','文章已发布');
    }
    public function destroyArticle(KbArticle $article) {
        $article->delete();
        return back()->with('success','已删除');
    }
}
