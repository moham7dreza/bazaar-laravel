<?php

namespace App\Policies;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use App\Models\Advertise\Advertisement;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdvertisementPolicy
{
    // run before all other policy checks
    public function before(User $user, string $ability): Response
    {
        if ($user->isAdmin()) {
            return Response::allow();
        }

        if ($ability !== 'forceDelete' && $user->can(UserPermission::SEE_PANEL)) {
            return Response::allow();
        }

        return Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->can(UserRole::WRITER) || $user->can(UserRole::EDITOR)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Advertisement $advertisement): Response
    {
        return $user->owns($advertisement)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->can(UserPermission::CREATE_AD)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Advertisement $advertisement): Response
    {
        return $user->owns($advertisement) && $user->can(UserPermission::EDIT_AD)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Advertisement $advertisement): Response
    {
        $check = $user->owns($advertisement)
            && $user->can(UserPermission::DESTROY_AD)
            && (is_null($advertisement->published_at) || now()->gt($advertisement->published_at));

        return $check
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Advertisement $advertisement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Advertisement $advertisement)
    {
        //
    }

    public function publish(User $user, Advertisement $advertisement)
    {
        return $user->can(UserPermission::PUBLISH_AD)
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
