<?php

declare(strict_types=1);

namespace Modules\Advertise\Policies;

use App\Enums\UserPermission;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Modules\Advertise\Models\Advertisement;

final class AdvertisementPolicy
{
    /*
    public function before(User $user, string $ability): void
    {

    }
    */

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->can(UserPermission::EditAds)
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
        return $user->can(UserPermission::CreateAd)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Advertisement $advertisement): Response
    {
        return $user->owns($advertisement) && $user->can(UserPermission::EditAd)
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Advertisement $advertisement): Response
    {
        $check = $user->owns($advertisement)
            && $user->can(UserPermission::DestroyAd)
            && ! $advertisement->isLive();

        return $check
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Advertisement $advertisement): void
    {

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Advertisement $advertisement): void
    {

    }

    public function publish(User $user, Advertisement $advertisement): Response
    {
        return $user->can(UserPermission::PublishAd)
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
