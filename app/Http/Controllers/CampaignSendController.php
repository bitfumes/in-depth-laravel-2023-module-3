<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

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
        dd($subscribers->count());

        return response()->json([
            'message' => 'Email sent successfully',
        ], 200);
    }
}
