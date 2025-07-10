<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function buyer_can_view_messages()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $message = Message::factory()->create([
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.index'));

        $response->assertStatus(200);
        $response->assertSee('Messages');
    }

    /** @test */
    public function vendor_can_view_messages()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $message = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
        ]);

        $response = $this->actingAs($vendor)->get(route('messages.index'));

        $response->assertStatus(200);
        $response->assertSee('Messages');
    }

    /** @test */
    public function user_can_send_message()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);

        $messageData = [
            'recipient_id' => $vendor->id,
            'subject' => 'Question about product',
            'content' => 'I have a question about your product.',
        ];

        $response = $this->actingAs($buyer)->post(route('messages.store'), $messageData);

        $response->assertRedirect(route('messages.index'));
        $this->assertDatabaseHas('messages', [
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
            'subject' => 'Question about product',
        ]);
    }

    /** @test */
    public function user_can_send_message_with_order_reference()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        $order = Order::factory()->create([
            'buyer_id' => $buyer->id,
            'vendor_id' => $vendor->id,
        ]);

        $messageData = [
            'recipient_id' => $vendor->id,
            'subject' => 'Order inquiry',
            'content' => 'I have a question about my order.',
            'order_id' => $order->id,
        ];

        $response = $this->actingAs($buyer)->post(route('messages.store'), $messageData);

        $response->assertRedirect(route('messages.index'));
        $this->assertDatabaseHas('messages', [
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function user_can_view_conversation()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message1 = Message::factory()->create([
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
            'subject' => 'Test Subject',
        ]);
        
        $message2 = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'subject' => 'Test Subject',
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.conversation', $vendor->id));

        $response->assertStatus(200);
        $response->assertSee($message1->content);
        $response->assertSee($message2->content);
    }

    /** @test */
    public function user_can_reply_to_message()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $originalMessage = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'subject' => 'Test Subject',
        ]);

        $replyData = [
            'content' => 'This is my reply to your message.',
            'subject' => 'Test Subject',
        ];

        $response = $this->actingAs($buyer)->post(route('messages.reply', $originalMessage), $replyData);

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
            'subject' => 'Test Subject',
            'content' => 'This is my reply to your message.',
        ]);
    }

    /** @test */
    public function message_is_marked_as_read_when_viewed()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => null,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.show', $message));

        $response->assertStatus(200);
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'read_at' => now(),
        ]);
    }

    /** @test */
    public function user_can_mark_message_as_read()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => null,
        ]);

        $response = $this->actingAs($buyer)->patch(route('messages.mark-read', $message));

        $response->assertRedirect();
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'read_at' => now(),
        ]);
    }

    /** @test */
    public function user_can_delete_message()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message = Message::factory()->create([
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer)->delete(route('messages.destroy', $message));

        $response->assertRedirect();
        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }

    /** @test */
    public function user_cannot_delete_other_user_message()
    {
        $buyer1 = User::factory()->create(['role' => 'buyer']);
        $buyer2 = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message = Message::factory()->create([
            'sender_id' => $buyer1->id,
            'recipient_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer2)->delete(route('messages.destroy', $message));

        $response->assertStatus(403);
        $this->assertDatabaseHas('messages', ['id' => $message->id]);
    }

    /** @test */
    public function messages_can_be_filtered_by_status()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $readMessage = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => now(),
        ]);
        
        $unreadMessage = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => null,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.index', ['status' => 'unread']));

        $response->assertStatus(200);
        $response->assertSee($unreadMessage->subject);
        $response->assertDontSee($readMessage->subject);
    }

    /** @test */
    public function messages_can_be_searched()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $message1 = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'subject' => 'Product inquiry',
            'content' => 'I have a question about your product.',
        ]);
        
        $message2 = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'subject' => 'Order status',
            'content' => 'What is the status of my order?',
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.index', ['search' => 'product']));

        $response->assertStatus(200);
        $response->assertSee($message1->subject);
        $response->assertDontSee($message2->subject);
    }

    /** @test */
    public function user_can_view_sent_messages()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $sentMessage = Message::factory()->create([
            'sender_id' => $buyer->id,
            'recipient_id' => $vendor->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.sent'));

        $response->assertStatus(200);
        $response->assertSee($sentMessage->subject);
    }

    /** @test */
    public function user_can_view_inbox()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        $receivedMessage = Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.inbox'));

        $response->assertStatus(200);
        $response->assertSee($receivedMessage->subject);
    }

    /** @test */
    public function unread_message_count_is_correct()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);
        
        Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => null,
        ]);
        
        Message::factory()->create([
            'sender_id' => $vendor->id,
            'recipient_id' => $buyer->id,
            'read_at' => null,
        ]);

        $response = $this->actingAs($buyer)->get(route('messages.unread-count'));

        $response->assertStatus(200);
        $response->assertJson(['count' => 2]);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_messages()
    {
        $response = $this->get(route('messages.index'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function message_validation_works()
    {
        $buyer = User::factory()->create(['role' => 'buyer']);
        $vendor = User::factory()->create(['role' => 'vendor']);

        // Test missing required fields
        $response = $this->actingAs($buyer)->post(route('messages.store'), []);

        $response->assertSessionHasErrors(['recipient_id', 'subject', 'content']);

        // Test invalid recipient
        $response = $this->actingAs($buyer)->post(route('messages.store'), [
            'recipient_id' => 99999,
            'subject' => 'Test',
            'content' => 'Test content',
        ]);

        $response->assertSessionHasErrors(['recipient_id']);
    }
} 