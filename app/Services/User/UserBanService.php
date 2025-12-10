<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User;
use Cog\Laravel\Ban\Events\ModelWasBanned;
use Cog\Laravel\Ban\Events\ModelWasUnbanned;
use Cog\Laravel\Ban\Models\Ban;
use Illuminate\Support\Facades\Date;

class UserBanService
{
    public function temporaryBan(
        User $user,
        Date $expiredAt,
        ?string $comment = null,
    ): Ban {
        return $this->banAndFireEvent($user, $expiredAt, $comment);
    }

    public function permanentBan(
        User $user,
        ?string $comment = null
    ): Ban {
        return $this->banAndFireEvent($user, $comment);
    }

    public function unban(User $user): void
    {
        $user->unban();

        event(new ModelWasUnbanned($user));
    }

    private function banAndFireEvent(
        User $user,
        ?Date $expiredAt = null,
        ?string $comment = null,
    ): Ban {
        $ban = $user->ban([
            'expired_at' => $expiredAt,
            'comment'    => $comment,
        ]);

        event(new ModelWasBanned($user, $ban));

        return $ban;
    }
}
