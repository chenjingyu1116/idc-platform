<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProductMapping;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
class ProductMappingController extends Controller {
    public function index() {
        $mappings = ProductMapping::with(['product','provider'])->latest()->paginate(20);
        return view('admin.product-mappings.index', compact('mappings'));
    }
    public function create() {
        $products = Product::all();
        $providers = Provider::all();
        return view('admin.product-mappings.create', compact('products','providers'));
    }
    public function store(Request $request) {
        $v = $request->validate([
            'product_id' => 'required|exists:products,id',
            'provider_id' => 'required|exists:providers,id',
            'upstream_product_id' => 'required|string',
        ]);
        ProductMapping::create($v);
        return redirect()->route('admin.product-mappings.index')->with('success','映射已创建');
    }
    public function destroy(ProductMapping $productMapping) {
        $productMapping->delete();
        return back()->with('success','已删除');
    }
}
