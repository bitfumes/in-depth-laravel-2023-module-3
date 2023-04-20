<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Models\Campaign;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = auth()->user()->campaigns;
        $campaigns->append('listName');

        return response(['data' => $campaigns]);
    }

    public function store(CampaignStoreRequest $request)
    {
        $user     = auth()->user();
        $campaign = $user->campaigns()->create($request->validated());

        return $campaign;
    }

    public function update(Campaign $campaign, CampaignUpdateRequest $request)
    {
        $campaign->update($request->validated());

        return $campaign;
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->noContent();
    }
}
