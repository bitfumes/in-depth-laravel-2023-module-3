<?php

namespace App\Console\Commands;

use App\Mail\CampaignMail;
use App\Models\Campaign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CampaignSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:send {campaign?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send the campaign to all subscribers';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if ($this->argument('campaign')) {
            $campaigns = Campaign::where('id', $this->argument('campaign'))->get();
        } else {
            $campaigns = Campaign::where('status', 1)->whereNotNull('scheduled_at')->get();
        }

        $campaigns->each(
            function ($campaign) {
                $list        = $campaign->list;
                $subscribers = $list->subscribers;

                $subscribers->each(
                    fn ($subscriber) => Mail::to($subscriber->email)
                        ->queue(new CampaignMail($campaign))
                );
            }
        );
    }
}
