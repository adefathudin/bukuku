<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategories;

class ProductsController extends BaseController
{

    public function index()
    {
        return view('products.index');
    }

    public function categories()
    {
        return view('products.section.categories');
    }

    public function listProductsTransaction(){
        $products = Products::with('category')->whereNotNull('category_id')->get();
        return response()->json($products);
    }

    public function listProductsDataTable(Request $request)
    {
        $query = Products::with(['category']);

        if ($request->name) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->category}%");
            });
        }

        if ($request->price) {
            $query->where('price', 'like', "%{$request->price}%");
        }

        if ($request->sort && $request->direction) {
            if ($request->sort === 'category_name') {
                $query->join('product_categories', 'products.category_id', '=', 'product_categories.id')
                    ->orderBy('product_categories.name', $request->direction)
                    ->select('products.*');
            } else {
                $query->orderBy($request->sort, $request->direction);
            }
        }
        $query2 = $query->clone();
        $stockOut = $query2->where('stock', '<=', 0)->count();

        if ($request->has('non_category') && $request->non_category == 'true') {
            $query->whereNull('category_id');
        }

        if ($request->stock_out && $request->stock_out == 'true') {
            $query->where('stock', '<=', 0);
        } else {
            $query->where('stock', '>', 0);
        }

        $dataTable = $query->paginate(5);

        $transformed = $dataTable->getCollection()->transform(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'stock' => $product->stock,
                'image' => $product->image,
                'category_name' => $product->category->name ?? '',
                'price' => $product->price,
            ];
        });

        return response()->json([
            'data' => $transformed,
            'current_page' => $dataTable->currentPage(),
            'last_page' => $dataTable->lastPage(),
            'per_page' => $dataTable->perPage(),
            'total' => $dataTable->total(),
            'stock_out' => $stockOut,
            'non_category' => $query->whereNull('category_id')->count(),
        ]);

    }

    public function showById(Request $request)
    {
        $id = $request->input('id');
        $product = Products::with(['category:id,name'])->find($id);

        $product = [
            'id' => $product->id,
            'name' => $product->name,
            'stock' => $product->stock,
            'image' => $product->image,
            'category_id' => $product->category->id ?? '',
            'category_name' => $product->category->name ?? '',
            'price' => $product->price,
        ];

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }
    }

    public function save(Request $request)
    {
        $product = Products::find($request->input('id'));

        if (!$product) {$request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->move(public_path('assets/images/products'), $imageName);
        }

        Products::create([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'category_id' => $request->input('category_id'),
            'image' => $imageName ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
        ]);
        }
        
        if ($request->hasFile('image')) {
            $imageName = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $imagePath = $request->file('image')->move(public_path('assets/images/products'), $imageName);
            if ($product->image && file_exists(public_path('assets/images/products/' . $product->image))) {
                unlink(public_path('assets/images/products/' . $product->image));
            }
            $product->image = $imageName;
        }
        
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->category_id = $request->input('category_id');
        $product->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Request $request)
    {
        $product = Products::find($request->input('id'));
        if ($product) {
            $product->delete();
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([

                'message' => 'Product not found',
            ], 404);
        }
    }

    public function getCategories()
    {
        $categories = ProductCategories::get();
        return response()->json($categories);
    }

    public function saveCategories(Request $request)
    {
        $save = ProductCategories::find($request->id);
        if ($save) {
            $save->update($request->all());
        } else {
            $save = ProductCategories::create($request->all());
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function deleteCategories(Request $request)
    {
        $id = $request->json('id');
        ProductCategories::where('id', $id)->delete();
        return response()->json([
            'success' => true,
        ]);
    }
}
