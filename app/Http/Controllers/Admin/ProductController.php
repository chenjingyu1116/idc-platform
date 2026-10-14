<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|max:20',
            'cpu' => 'nullable|string',
            'memory' => 'nullable|string',
            'disk' => 'nullable|string',
            'bandwidth' => 'nullable|string',
            'stock' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        Product::create([
            'name' => $v['name'],
            'slug' => Str::slug($v['name']) . '-' . Str::random(4),
            'description' => $v['description'] ?? '',
            'price' => $v['price'],
            'billing_cycle' => $v['billing_cycle'],
            'config' => [
                'cpu' => $v['cpu'] ?? '1核',
                'memory' => $v['memory'] ?? '1G',
                'disk' => $v['disk'] ?? '20G',
                'bandwidth' => $v['bandwidth'] ?? '20M',
            ],
            'stock' => $v['stock'] ?? -1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.products.index')->with('success', '产品已添加');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $v = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|string|max:20',
            'stock' => 'nullable|integer',
        ]);

        $product->update([
            'name' => $v['name'],
            'description' => $v['description'] ?? '',
            'price' => $v['price'],
            'billing_cycle' => $v['billing_cycle'],
            'config' => [
                'cpu' => $request->input('cpu', '1核'),
                'memory' => $request->input('memory', '1G'),
                'disk' => $request->input('disk', '20G'),
                'bandwidth' => $request->input('bandwidth', '20M'),
            ],
            'stock' => $v['stock'] ?? -1,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.products.index')->with('success', '产品已更新');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', '产品已删除');
    }
}
