<?php

namespace App\Http\Controllers;

use App\Models\EmailList;

class EmailListController extends Controller
{
    public function store()
    {
        return EmailList::create([
            'name'    => request('name'),
            'user_id' => auth()->id(),
        ]);
    }
}
