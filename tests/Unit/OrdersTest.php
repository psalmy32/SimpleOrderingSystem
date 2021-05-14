<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Orders;

class OrdersTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function testExample()
    {
        $this->assertTrue(true);
    }


    public function testCreateOrder()
    {
       $data = 
       [
            'origin' => ["6.4697805", "3.7415328"],
            'destination' => ["6.741059", "3.4189803"]
        ];
        $this->withoutExceptionHandling();
        $response = $this->post('/api/orders', [
            'origin' => ["6.4697805", "3.7415328"],
            'destination' => ["6.741059", "3.4189803"]
        ]);
        $response->assertStatus(200);
    }

    public function testTakeOrder()
    {
        $this->withoutExceptionHandling();
        $response = $this->patch('/api/orders/15', [
            'status' => "TAKEN"
        ]);
        $response->assertStatus(200);
    }

    public function testGetAllOrders()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/orders?page=1&limit=10', [
        ]);
        $response->assertStatus(200);
    }
}
