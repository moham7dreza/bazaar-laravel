<?php

declare(strict_types=1);

namespace Modules\Payment\Http\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Modules\Payment\Models\Payment;

class ZarinpalService
{
    private $merchantId;

    private $baseUrl;

    public function __construct()
    {
        $this->merchantId = config('payment.drivers.zarinpal.merchantId');
        $this->baseUrl    = config('payment.drivers.zarinpal.apiPaymentUrl');
    }

    /**
     * @throws ConnectionException
     */
    public function createPayment($amount, $description, $userId, $advertisementId, $callbackUrl): array
    {

        $response = Http::post($this->baseUrl . '/pg/v4/payment/request.json', [
            'merchant_id'  => $this->merchantId,
            'amount'       => $amount,
            'description'  => $description,
            'callback_url' => $callbackUrl,
            'metadata'     => [
                'userId'          => $userId,
                'advertisementId' => $advertisementId,
            ],
        ]);
        $result = $response->json();

        if (isset(\Illuminate\Support\Arr::get($result, 'data.code')) && 100 === \Illuminate\Support\Arr::get($result, 'data.code'))
        {
            $payment = Payment::query()->create([
                'user_id'          => $userId,
                'advertisement_id' => $advertisementId,
                'amount'           => $amount,
                'description'      => $description,
                'authority'        => \Illuminate\Support\Arr::get($result, 'data.authority'),
                'status'           => 'pending',
                'gateway_response' => $result,
            ]);

            return [
                'success'      => true,
                'payement_url' => $this->baseUrl . '/pg/StartPay/' . \Illuminate\Support\Arr::get($result, 'data.authority'),
                'authority'    => \Illuminate\Support\Arr::get($result, 'data.authority'),
                'payment_id'   => $payment->id,
            ];
        }

        return [
            'success' => false,
            'message' => 'خطا در ایجاد تراکنش',
        ];
    }

    /**
     * @throws ConnectionException
     */
    public function verifyPayment($authority, $amount): array
    {

        $response = Http::post($this->baseUrl . '/pg/v4/payment/verify.json', [
            'merchant_id' => $this->merchantId,
            'authority'   => $authority,
            'amount'      => $amount,
        ]);

        $result = $response->json();

        if (isset(\Illuminate\Support\Arr::get($result, 'data.code')) && 100 === \Illuminate\Support\Arr::get($result, 'data.code'))
        {
            $payment = Payment::query()->where('authority', $authority)->first();

            if ($payment)
            {
                $payment->update([
                    'status'           => 'paid',
                    'ref_id'           => \Illuminate\Support\Arr::get($result, 'data.ref_id'),
                    'card_pan'         => \Illuminate\Support\Arr::get($result, 'data.card_pan', null),
                    'trace_no'         => \Illuminate\Support\Arr::get($result, 'data.trace_no', null),
                    'gateway_response' => $result,
                ]);

                return [
                    'success' => true,
                    'message' => 'تراکنش با موفقیت انجام شد',
                    'payment' => $payment,
                ];
            }

            return [
                'success' => false,
                'message' => 'تراکنش یافت نشد',
            ];
        }

        return [
            'success' => false,
            'message' => 'خطا در تایید تراکنش',
        ];
    }
}
