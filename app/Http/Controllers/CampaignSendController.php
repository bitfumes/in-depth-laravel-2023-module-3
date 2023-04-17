<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Support\Facades\Artisan;

class CampaignSendController extends Controller
{
    public function send(Campaign $campaign)
    {
        $campaign->emails()->create([
            'subject' => $campaign->subject,
            'content' => $campaign->content,
        ]);

        if (is_null($campaign->scheduled_at)) {
            Artisan::call("campaign:send {$campaign->id}");
        }

        return response()->json([
            'message' => 'Email sent successfully',
        ], 200);
    }
}
