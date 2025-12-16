<?php

namespace AnkitFromIndia\MX18\Webhooks;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        
        // Verify webhook signature if secret is configured
        if (config('mx18.webhook_secret')) {
            $signature = $request->header('X-MX18-Signature');
            $expectedSignature = hash_hmac('sha256', $request->getContent(), config('mx18.webhook_secret'));
            
            if (!hash_equals($expectedSignature, $signature)) {
                return response('Unauthorized', 401);
            }
        }

        // Fire event for webhook handling
        event(new WebhookReceived($payload));

        return response('OK', 200);
    }
}
