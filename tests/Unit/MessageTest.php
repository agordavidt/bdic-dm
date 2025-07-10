<?php

namespace Tests\Unit;

use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function message_belongs_to_sender()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);
        $this->assertInstanceOf(User::class, $message->sender);
        $this->assertEquals($sender->id, $message->sender->id);
    }

    /** @test */
    public function message_belongs_to_recipient()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
        ]);
        $this->assertInstanceOf(User::class, $message->recipient);
        $this->assertEquals($recipient->id, $message->recipient->id);
    }

    /** @test */
    public function message_may_belong_to_order()
    {
        $sender = User::factory()->create();
        $recipient = User::factory()->create();
        $order = Order::factory()->create();
        $message = Message::factory()->create([
            'sender_id' => $sender->id,
            'recipient_id' => $recipient->id,
            'order_id' => $order->id,
        ]);
        $this->assertInstanceOf(Order::class, $message->order);
        $this->assertEquals($order->id, $message->order->id);
    }

    /** @test */
    public function message_can_be_marked_as_read()
    {
        $message = Message::factory()->create(['read_at' => null]);
        $message->markAsRead();
        $this->assertNotNull($message->fresh()->read_at);
    }

    /** @test */
    public function message_is_read_returns_true_if_read_at_is_set()
    {
        $message = Message::factory()->create(['read_at' => now()]);
        $this->assertTrue($message->isRead());
    }

    /** @test */
    public function message_is_read_returns_false_if_read_at_is_null()
    {
        $message = Message::factory()->create(['read_at' => null]);
        $this->assertFalse($message->isRead());
    }
} 