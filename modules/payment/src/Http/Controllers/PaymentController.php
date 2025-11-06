<?php

declare(strict_types=1);

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Payment\Http\Services\ZarinpalService;
use Modules\Payment\Models\Payment;

class PaymentController extends Controller
{
    public function __construct(
        private readonly ZarinpalService $zarinpalService,
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'amount'      => 'required|numeric|min:1000',
            'description' => 'required|string|max:255',
        ]);

        $result = $this->zarinpalService->createPayment(
            $request->amount,
            $request->description,
            3,
            24,
            route('api.payment.verify')
        );

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    public function verify(Request $request): JsonResponse
    {

        $authority = $request->get('Authority') ?? $request->get('authority');
        $status    = $request->get('Status')    ?? $request->get('status');

        if ( ! $authority || ! $status)
        {
            return response()->json([
                'success' => false,
                'message' => 'اطلاعات تراکنش معتبر نیست',
            ], 400);
        }

        if ('OK' !== $status)
        {

            return response()->json([
                'success' => false,
                'message' => 'تراکنش ناموفق بود',
            ], 400);
        }

        $payment = Payment::where('authority', $authority)->first();

        if ( ! $payment)
        {
            return response()->json([
                'success' => false,
                'message' => 'تراکنش یافت نشد',
            ], 400);
        }

        $result = $this->zarinpalService->verifyPayment($authority, $payment->amount);

        if ( ! $result['success'])
        {
            return response()->json([
                'success' => false,
                'message' => 'خطا در تایید تراکنش',
            ], 400);
        }

        return response()->json($result, $result['success'] ? 200 : 400);
    }
}
