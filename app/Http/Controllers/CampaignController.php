<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required',
            'subject'    => 'required',
            'content'    => 'required',
            'from_name'  => 'required',
            'from_email' => ['required', 'email'],
            'list_id'    => ['required', 'exists:email_lists,id'],
        ]);

        $user     = auth()->user();
        $campaign = $user->campaigns()->create($data);

        return $campaign;
    }
}
