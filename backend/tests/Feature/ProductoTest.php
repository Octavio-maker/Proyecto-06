<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    // Helper: devuelve $this ya autenticado como admin
    private function actingAsAdmin()
    {
        $admin = User::factory()->create(['rol' => 'admin']);
        return $this->actingAs($admin, 'sanctum');
    }

    // Helper: devuelve $this ya autenticado como cliente
    private function actingAsCliente()
    {
        $cliente = User::factory()->create(['rol' => 'cliente']);
        return $this->actingAs($cliente, 'sanctum');
    }

    // ─────────────────────────────────────────────
    // LISTAR
    // ─────────────────────────────────────────────
    public function test_puede_listar_productos(): void
    {
        Producto::factory(5)->create();

        $this->actingAsAdmin()
             ->getJson('/api/productos')
             ->assertOk()
             ->assertJsonCount(5, 'data');
    }

    public function test_invitado_no_puede_listar_productos(): void
    {
        $this->getJson('/api/productos')
             ->assertUnauthorized(); // 401
    }

    // ─────────────────────────────────────────────
    // CREAR
    // ─────────────────────────────────────────────
    public function test_admin_puede_crear_producto(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/productos', [
                 'nombre' => 'Laptop Dell',
                 'precio' => 1299.99,
                 'stock'  => 10,
             ])
             ->assertCreated()
             ->assertJsonPath('data.nombre', 'Laptop Dell');

        $this->assertDatabaseHas('productos', ['nombre' => 'Laptop Dell']);
    }

    public function test_crear_producto_falla_sin_nombre(): void
    {
        $this->actingAsAdmin()
             ->postJson('/api/productos', [
                 'precio' => 100,
                 'stock'  => 5,
             ])
             ->assertStatus(422)
             ->assertJsonValidationErrors(['nombre']);
    }

    public function test_cliente_no_puede_crear_producto(): void
    {
        $this->actingAsCliente()
             ->postJson('/api/productos', [
                 'nombre' => 'Producto Trampa',
                 'precio' => 50,
                 'stock'  => 1,
             ])
             ->assertForbidden(); // 403
    }

    // ─────────────────────────────────────────────
    // VER UNO
    // ─────────────────────────────────────────────
    public function test_puede_ver_un_producto(): void
    {
        $producto = Producto::factory()->create(['nombre' => 'Monitor LG']);

        $this->actingAsAdmin()
             ->getJson("/api/productos/{$producto->id}")
             ->assertOk()
             ->assertJsonPath('data.nombre', 'Monitor LG');
    }

    // ─────────────────────────────────────────────
    // ACTUALIZAR
    // ─────────────────────────────────────────────
    public function test_admin_puede_actualizar_producto(): void
    {
        $producto = Producto::factory()->create();

        $this->actingAsAdmin()
             ->putJson("/api/productos/{$producto->id}", [
                 'nombre' => 'Nombre Actualizado',
                 'precio' => 999,
                 'stock'  => 5,
             ])
             ->assertOk()
             ->assertJsonPath('data.nombre', 'Nombre Actualizado');

        $this->assertDatabaseHas('productos', ['nombre' => 'Nombre Actualizado']);
    }

    
    public function test_admin_puede_eliminar_producto(): void
    {
        $producto = Producto::factory()->create();

        $this->actingAsAdmin()
             ->deleteJson("/api/productos/{$producto->id}")
             ->assertNoContent(); // 204

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_cliente_no_puede_eliminar_producto(): void
    {
        $producto = Producto::factory()->create();

        $this->actingAsCliente()
             ->deleteJson("/api/productos/{$producto->id}")
             ->assertForbidden(); // 403
    }
}