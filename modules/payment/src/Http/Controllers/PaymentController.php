<?php

declare(strict_types=1);

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Modules\Payment\Enums\PaymentStatus;
use Modules\Payment\Http\Services\ZarinpalService;
use Modules\Payment\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(
        private readonly ZarinpalService $zarinpalService,
    ) {
    }

    /**
     * @throws ConnectionException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'amount'      => ['required', 'numeric', 'min:1000'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $result = $this->zarinpalService->createPayment(
            $request->amount,
            $request->description,
            3,
            24,
            route('api.payment.verify')
        );

        return new JsonResponse($result, Arr::get($result, 'success') ? 200 : 400);
    }

    /**
     * @throws ConnectionException
     */
    public function verify(Request $request): RedirectResponse
    {

        $authority = $request->get('Authority') ?? $request->get('authority');
        $status    = $request->get('Status')    ?? $request->get('status');

        $failureRedirect = redirect(config()->string('app.frontend_url') . '/success-payment?Authority=&Status=FAIL');

        if ( ! $authority || 'OK' !== $status)
        {
            return $failureRedirect;
        }

        $payment = Payment::query()->where('authority', $authority)->first();

        if ( ! $payment)
        {
            return $failureRedirect;
        }

        $result = $this->zarinpalService->verifyPayment($authority, $payment->amount);

        if ( ! Arr::get($result, 'success'))
        {
            return $failureRedirect;
        }

        $payment->update([
            'status'           => PaymentStatus::Paid,
            'ref_id'           => Arr::get($result, 'payment.ref_id'),
            'card_pan'         => Arr::get($result, 'payment.card_pan'),
            'gateway_response' => Arr::get($result, 'payment.gateway_response'),
        ]);

        return redirect(config()->string('app.frontend_url') . '/success-payment?Authority=' . $authority . '&Status=OK');
    }
}
