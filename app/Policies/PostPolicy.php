<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */

    public function before(User $user, string $ability)
    {
        /* 
        How Laravel interprets it
        true → allow immediately.
        false → deny immediately.
        null → means "no decision made here" → so Laravel continues to check the specific policy method (like update, delete, etc.).
        So it does NOT return false for non-admins. It just falls back to the normal policy rules.
        */
        if ($user->isAdmin()) {
            return true;
        }
    }
    public function viewAny(User $user): bool
    {
        return true; // all registered users can view post list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        return true; // All authenticated users can view individual posts
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // All authenticated users can create posts
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post)
    {
        return $post->user_id === $user->id || $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }

    public function published(User $user, Post $post)
    {
        if ($user->isEditor()) {
            return true;
        }

        $user->id === $post->user_id;
    }
}
