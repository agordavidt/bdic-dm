<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;

class MessagePolicy
{
    /**
     * Determine whether the user can update the message (mark as read).
     */
    public function update(User $user, Message $message)
    {
        return $user->id === $message->receiver_id;
    }
} 