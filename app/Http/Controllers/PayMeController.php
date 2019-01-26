<?php

namespace App\Http\Controllers;

use App\Services\ClearingService;
use Illuminate\Http\Request;

class PayMeController extends Controller
{

    /**
     * create a payment request.
     *
     * @param Request $request
     *  The request service.
     * @param ClearingService $clearing_service
     *  The clearing service.
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function store(Request $request, ClearingService $clearing_service)
    {
        $missing = false;
        foreach (['sale_price', 'currency', 'product_name'] as $key) {
            if (empty($request->{$key})) {
                $missing = true;
                break;
            }
        }
        if ($missing) {
            return response()->json([
                'error' => 'One of the items is missing: sale_price, currency, product_name'
            ], 400);
        }
        $results = $clearing_service->paymentRequest(
            $request->sale_price,
            $request->currency,
            $request->product_name
        );

        if (!$results) {
            // We won't expose the any log since we might give information we
            // don't want to.
            return response()->json(['message' => 'Something went wrong during the clearing. Please check logs'], 400);
        }

        return response()->json(['message' => 'The clearing process went OK'], 200);
    }
}
