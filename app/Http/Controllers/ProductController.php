<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Product::query()->paginate(5);
        return response()->json($posts, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Product::find($id);
        if($post) {
            return response()->json($post, 202);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if($product) {
            $product->update($request->all());
            $product->save();
            return response()->json($product, 200);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Product::destroy($id)) {
            return response()->json(['message' => 'Produto deletado com sucesso'], 201);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }
}
