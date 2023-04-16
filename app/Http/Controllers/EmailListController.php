<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    public function index()
    {
        $lists = EmailList::where('user_id', auth()->id())->get();
        return response([
            'data' => $lists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        return EmailList::create([
            'name'    => $request->name,
            'user_id' => auth()->id(),
        ]);
    }

    public function update(Request $request, EmailList $list)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $list->update([
            'name' => $request->name,
        ]);

        return response($list);
    }

    public function destroy(EmailList $list)
    {
        $list->delete();
        return response(null);
    }
}
