<?php

namespace App\Http\Controllers;

use App\Mail\CampaignMail;
use App\Models\Campaign;
use Illuminate\Support\Facades\Mail;

class CampaignSendController extends Controller
{
    public function send(Campaign $campaign)
    {
        $campaign->emails()->create([
            'subject' => $campaign->subject,
            'content' => $campaign->content,
        ]);

        $list        = $campaign->list;
        $subscribers = $list->subscribers;

        if (is_null($campaign->scheduled_at)) {
            $subscribers->each(
                fn ($subscriber) => Mail::to($subscriber->email)
                    ->queue(new CampaignMail($campaign))
            );
        }

        return response()->json([
            'message' => 'Email sent successfully',
        ], 200);
    }
}
