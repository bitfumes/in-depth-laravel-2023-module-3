<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    public function index()
    {
        $lists = EmailList::where('user_id', auth()->id())->get();
        $lists->append('subscribeLink');
        return response([
            'data' => $lists,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'sometimes',
        ]);

        return EmailList::create([
            'name'        => $request->name,
            'description' => $request->description,
            'user_id'     => auth()->id(),
        ]);
    }

    public function update(Request $request, EmailList $list)
    {
        $request->validate([
            'name'        => 'required',
            'description' => 'sometimes',
        ]);

        $list->update($request->only('name', 'description'));

        return response($list);
    }

    public function destroy(EmailList $list)
    {
        $list->delete();
        return response(null);
    }

    public function show($list)
    {
        $list = EmailList::where('user_id', auth()->id())->findOrFail($list);
        return response($list);
    }
}
