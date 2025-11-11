<?php

declare(strict_types=1);

namespace Modules\Auth\Services;

use Amiriun\SMS\DataContracts\SendSMSDTO;
use Amiriun\SMS\Services\SMSService;
use App\Models\User;
use Illuminate\Support\Str;
use Modules\Auth\Enums\NoticeType;
use Modules\Auth\Models\Otp;
use Random\RandomException;

final readonly class ConsumeOneTimePasswordService
{
    public function __construct(
        private SMSService $smsService,
    ) {
    }

    /**
     * @throws RandomException
     */
    public function prepareAndSend($mobile): array
    {
        $user = User::query()->firstWhere('mobile', $mobile);

        $otpCode = random_int(1000, 9999);
        $token   = Str::random(60);

        Otp::query()->updateOrCreate(
            ['login_id' => $mobile, 'used' => 0],
            [
                'token'    => $token,
                'otp_code' => $otpCode,
                'login_id' => $mobile,
                'type'     => NoticeType::Sms,
                'attempts' => 0,
                'user_id'  => $user?->id,
            ]
        );

        $data = new SendSMSDTO();
        $data->setSenderNumber('300024444');
        $data->setMessage($otpCode);
        $data->setTo($mobile);

        $this->smsService->send($data);

        return [
            'token' => $token,
            'otp'   => $otpCode,
        ];
    }
}
