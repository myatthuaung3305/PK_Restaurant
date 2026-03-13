<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_uses_profile_name_when_placing_order(): void
    {
        $user = User::factory()->create([
            'name' => 'Profile Name',
        ]);
        $menuItem = MenuItem::query()->create([
            'name' => 'Tea Leaf Salad',
            'category' => 'Salad',
            'description' => 'Fresh salad',
            'price' => 7.50,
            'image_path' => '',
            'is_active' => true,
        ]);

        $cart = [
            (string) $menuItem->id => [
                'menu_item_id' => $menuItem->id,
                'name' => 'Tea Leaf Salad',
                'price' => 7.50,
                'quantity' => 2,
            ],
        ];

        $response = $this
            ->actingAs($user)
            ->withSession(['cart' => $cart])
            ->post('/order/place', [
                'phone' => '+65 9888 1234',
                'notes' => 'No peanuts',
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'customer_name' => 'Profile Name',
            'phone' => '+6598881234',
            'notes' => 'No peanuts',
            'total_amount' => 15.00,
        ]);
    }
}
