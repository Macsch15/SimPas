<?php

namespace SimPas\Http\Controllers;

use SimPas\Http\Requests\PastebinRequest;
use SimPas\Http\Requests;
use SimPas\PastebinRecord;
use Auth;

class PastebinController extends Controller
{
    /**
     * Create pastebin
     *
     * @param SimPas\PastebinRecord $record
     * @param SimPas\Http\Requests\PastebinRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(PastebinRecord $record, PastebinRequest $request)
    {
        $record->unique_id = str_random(20);
        $record->user_id = Auth::guest() ? 0 : Auth::id();
        $record->title = $request->title;
        $record->content = $request->content;

        $record->save();

        return redirect()->route('pastebin.show', [
            'unique_id' => $record->find($record->id)['unique_id']
        ]);
    }

    /**
     * Show pastebin
     *
     * @param SimPas\PastebinRecord $record
     * @param string $unique_id
     * @return \Illuminate\Http\Response
     */
    public function show(PastebinRecord $record, $unique_id)
    {
        return view('pastebin.show', [
            'entity' => $record->where('unique_id', $unique_id)->first()
        ]);
    }

    /**
     * Delete pastebin
     *
     * @param SimPas\PastebinRecord $record
     * @param string $unique_id
     * @throws \Exception
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(PastebinRecord $record, $unique_id)
    {
        $entity = $record->where('unique_id', $unique_id)->first();

        if (Auth::id() !== $entity->user_id) {
            throw new \Exception('No permission');
        }

        $entity->delete();

        return redirect('/');
    }

    /**
     * Show entities for user
     *
     * @param SimPas\PastebinRecord $record 
     * @throws \Exception
     * @return \Illuminate\Http\Response
     */
    public function entities(PastebinRecord $record)
    {
        if (Auth::guest() === true) {
            throw new \Exception('Only registered users can use this.');
        }

        $entity = $record->where('user_id', Auth::id())->get();

        return $entity;

    }
}
