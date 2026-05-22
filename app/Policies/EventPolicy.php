<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['organizer', 'super-admin']);
    }

    public function view(User $user, Event $event): bool
    {
        return $user->hasRole('super-admin') || $event->organizer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['organizer', 'super-admin']);
    }

    public function update(User $user, Event $event): bool
    {
        return $user->hasRole('super-admin') || $event->organizer_id === $user->id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->hasRole('super-admin') || $event->organizer_id === $user->id;
    }
}
