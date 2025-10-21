<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiJsonResponse;
use Carbon\CarbonInterval;
use Context;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Timebox;
use Modules\Auth\Http\Requests\LoginOtpRequest;
use Modules\Auth\Services\ConsumeOneTimePasswordService;
use Random\RandomException;
use Throwable;

final class RegisteredUserWithOTPController extends Controller
{
    /**
     * @throws Throwable
     * @throws RandomException
     */
    public function __invoke(LoginOtpRequest $request, ConsumeOneTimePasswordService $service): JsonResponse
    {
        Context::increment('metrics.login_otp_attempts');

        return new Timebox()->call(
            callback: function () use ($request, $service) {

                $data = $service->prepareAndSend($request->mobile);

                return ApiJsonResponse::success($data, message: 'کد تایید با موفقیت ارسال شد');

            },
            microseconds: CarbonInterval::microseconds(200)->microseconds
        );
    }
}
