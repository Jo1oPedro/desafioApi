<?php

namespace Api;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ProductTest extends TestCase
{
    CONST ROUTE = 'api/products';
    /**
     * A basic unit test example.
     */

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh --seed');
    }

    public function test_deve_retornar_todos_produtos_com_sucesso(): void
    {
        $response = $this->json('GET', self::ROUTE);
        $response->assertStatus(200);
    }

    public function test_deve_retornar_produto_especifico_com_sucesso(): void
    {
        $response = $this->json('GET', self::ROUTE . "/1");
        $response->assertStatus(202);
    }

    public function test_nao_deve_criar_produto_com_sucesso(): void
    {
        $response = $this->postJson(self::ROUTE, [
            'nome' => 'Cascata',
            'descricao' => 'Produto qualquer',
            ''
        ]);

        $response->assertStatus(422);
    }

    public function test_deve_criar_produto_com_sucesso(): void
    {
        $response = $this->postJson(self::ROUTE, [
            'nome' => 'Cascata',
            'descricao' => 'Produto qualquer',
            'preco' => 22.76,
            'quantidade' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_nao_deve_atualizar_produto_com_sucesso(): void
    {
        $response = $this->putJson(self::ROUTE . "/1", [
            'descricao' => 123.1,
        ]);

        $response->assertStatus(422);
    }

    public function test_deve_atualizar_produto_com_sucesso(): void
    {
        $response = $this->putJson(self::ROUTE . "/1", [
            'nome' => 'Cascata2',
            'descricao' => 'Produto qualquer2',
            'preco' => 22.76,
            'quantidade' => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_deve_deletar_produto_com_sucesso(): void
    {
        $response = $this->delete(self::ROUTE . "/1");
        $response->assertStatus(200);
        if(Product::find(1)) {
            $this->fail();
        }
    }

    public function test_nao_deve_deletar_produto_com_sucesso(): void
    {
        $response = $this->delete(self::ROUTE . "/19674");
        $response->assertStatus(404);
    }
}
