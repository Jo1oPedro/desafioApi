<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Exibe uma lista completade todos os produtos no banco paginada de 5 em 5 produtos.
     */
    public function index()
    {
        $posts = Product::query()->paginate(5);
        return response()->json($posts, 200);
    }

    /**
     * Armazena um novo produto no banco de dados caso o mesmo seja validado
     * pelas regras presentes no StoreProductRequest.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 200);
    }

    /**
     * Exibe as informações de um produto no banco caso o mesmo exista.
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
     * Atualiza as informações de um produto no banco, caso ele seja validado pelas regras
     * presentes no Update Product Request, baseado no
     * parametro enviada na rota e recebido pelo parametro $id do método.
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
     * Remove um produto do banco baseado no id enviado pela requisição,
     * caso o mesmo exista no banco de dados.
     */
    public function destroy(string $id)
    {
        if(Product::destroy($id)) {
            return response()->json(['message' => 'Produto deletado com sucesso'], 204);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }
}
