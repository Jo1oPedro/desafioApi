<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

/**
 * @OA\Info(
 *   title="API Desafio",
 *   version="1.0",
 *   contact={
 *     "email": "joao.pedreira@estudante.ufjf.br"
 *   }
 * )
 */

class ProductController extends Controller
{
    /**
     * @OA\GET(
     *  tags={"Product"},
     *  summary="Endpoint responsável por retornar todos os produtos paginados",
     *  description="Exibe uma lista completa de todos os produtos no banco paginada de 5 em 5 produtos.",
     *  path="/api/products",
     *  @OA\Response(
     *    response=200,
     *    description="Todos os produtos retornados com paginação",
     *    @OA\JsonContent(
     *       @OA\Property(property="products", type="string", example="'current_page': 1, 'data':[{'id': 1,'nome': 'cascata','descricao': 'teste', 'preco': 0, 'quantidade': 7, 'created_at': '2023-11-08T15:10:55.000000Z', 'updated_at': '2023-11-08T15:10:55.000000Z'}, {'id': 2,'nome': 'cascata2','descricao': 'teste2', 'preco': 0, 'quantidade': 7, 'created_at': '2023-11-08T15:10:55.000000Z', 'updated_at': '2023-11-08T15:10:55.000000Z'}], ")
     *    )
     *  ),
     * )
     */
    public function index()
    {
        $posts = Product::query()->paginate(5);
        return response()->json(['products' => $posts], 200);
    }

    /**
     * Armazena um novo produto no banco de dados caso o mesmo seja validado
     * pelas regras presentes no StoreProductRequest.
     */
    /**
     * @OA\POST(
     *  tags={"Product"},
     *  summary="Endpoint para criar um produto",
     *  description="Armazena um novo produto no banco de dados caso o mesmo seja validado pelas regras presentes no StoreProductRequest",
     *  path="/api/products",
     *  @OA\RequestBody(
     *     required=true,
     *     description="Dados do produto a ser criado",
     *     @OA\JsonContent(
     *       @OA\Property(property="nome", type="string", example="Produto A"),
     *       @OA\Property(property="descricao", type="string", example="Uma breve descrição do produto"),
     *       @OA\Property(property="preco", type="number", format="float", example=29.99),
     *       @OA\Property(property="quantidade", type="integer", example=10)
     *     )
     *   ),
     *  @OA\Response(
     *    response=200,
     *    description="Produto criado com sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="['id': 1,'nome': 'Produto A','descricao': 'Uma breve descrição do produto', 'preco': 29.99, 'quantidade': 10, 'created_at': '2023-11-08T15:10:55.000000Z', 'updated_at': '2023-11-08T15:10:55.000000Z']")
     *    )
     *  ),
     *  @OA\Response(
     *    response=422,
     *    description="Algum erro ocorreu durante a criação do produto",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Falha para criar o produto"),
     *    )
     *  )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        return response()->json(['product' => $product], 200);
    }

    /**
     * @OA\GET(
     *  tags={"Product"},
     *  summary="Endpoint para recuperar um produto especifico",
     *  description="Exibe um produto selecionado no parametro da rota",
     *  path="/api/products/{id}",
     *  @OA\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,
     *    description="ID do produto a ser pesquisado",
     *    @OA\Schema(type="integer")
     *   ),
     *  @OA\Response(
     *    response=200,
     *    description="Produto encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="product", type="string", example="['id': 1,'nome': 'cascata','descricao': 'teste', 'preco': 0, 'quantidade': 7, 'created_at': '2023-11-08T15:10:55.000000Z', 'updated_at': '2023-11-08T15:10:55.000000Z']")
     *    )
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Produto não foi encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Produto não encontrado"),
     *    )
     *  )
     * )
     */
    public function show(string $id)
    {
        $post = Product::find($id);
        if($post) {
            return response()->json(['product' => $post], 202);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * @OA\PUT(
     *  tags={"Product"},
     *  summary="Endpoint para editar um produto",
     *  description="Atualiza as informações de um produto no banco, caso ele seja validado pelas regras presentes no Update Product Request, baseado no parametro enviada na rota e recebido pelo parametro $id do método.",
     *  path="/api/products/{id}",
     *  @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID do produto a ser editado",
     *     @OA\Schema(type="integer")
     *    ),
     *  @OA\RequestBody(
     *     required=false,
     *     description="Dados do produto a ser editado",
     *     @OA\JsonContent(
     *       @OA\Property(property="nome", type="string", example="Produto A"),
     *       @OA\Property(property="descricao", type="string", example="Uma breve descrição do produto"),
     *       @OA\Property(property="preco", type="number", format="float", example=29.99),
     *       @OA\Property(property="quantidade", type="integer", example=10)
     *     )
     *   ),
     *  @OA\Response(
     *    response=200,
     *    description="Produto editado com sucesso",
     *    @OA\JsonContent(
     *       @OA\Property(property="product", type="string", example="['id': 1,'nome': 'Produto A','descricao': 'Uma breve descrição do produto', 'preco': 29.99, 'quantidade': 10, 'created_at': '2023-11-08T15:10:55.000000Z', 'updated_at': '2023-11-08T15:10:55.000000Z']")
     *    )
     *  ),
     *  @OA\Response(
     *     response=404,
     *     description="Produto não encontrado",
     *     @OA\JsonContent(
     *        @OA\Property(property="message", type="string", example="Produto não encontrado"),
     *     )
     *   ),
     *  @OA\Response(
     *    response=422,
     *    description="Algum erro ocorreu durante a edição do produto",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Falha para criar o produto"),
     *    )
     *  )
     * )
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::find($id);
        if($product) {
            $product->update($request->all());
            $product->save();
            return response()->json(['product' => $product], 200);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }

    /**
     * @OA\DELETE(
     *  tags={"Product"},
     *  summary="Endpoint para deletar um produto",
     *  description="Remove um produto do banco baseado no id enviado pela requisição, caso o mesmo exista no banco de dados",
     *  path="/api/products/{id}",
     *  @OA\Parameter(
     *    name="id",
     *    in="path",
     *    required=true,
     *    description="ID do produto a ser deletado",
     *    @OA\Schema(type="integer")
     *  ),
     *  @OA\Response(
     *    response=200,
     *    description="",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Produto deletado com sucesso")
     *    )
     *  ),
     *  @OA\Response(
     *    response=404,
     *    description="Produto não foi encontrado",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Produto não encontrado"),
     *    )
     *  )
     * )
     */
    public function destroy(string $id)
    {
        if(Product::destroy($id)) {
            return response()->json(['message' => 'Produto deletado com sucesso'], 200);
        }
        return response()->json(['message' => 'Produto não encontrado'], 404);
    }
}
