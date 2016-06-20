<?php

namespace SimPas\Http\Controllers;

use SimPas\Http\Requests\PastebinRequest;
use SimPas\Http\Requests;
use SimPas\Repository\PastebinRecord;
use Auth;
use Session;

class PastebinController extends ControllerAbstract
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
        $record->disable_syntax_highlighting = $request->has('disable_syntax_highlighting');
        $record->is_private = $request->has('visibility.private');

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
        $entity->delete();

        Session::flash('flash_message', 'Pastebin successfully deleted');

        return redirect('/');
    }

    /**
     * Show edit form
     *
     * @param SimPas\PastebinRecord $record
     * @param string $unique_id
     * @return \Illuminate\Http\Response
     */
    public function edit(PastebinRecord $record, $unique_id)
    {
        $record = $record->where('unique_id', $unique_id)->first();

        return view('pastebin.edit', ['entity' => $record, 'unique_id' => $unique_id]);
    }

    /**
     * Update pastebin record in the database
     *
     * @param SimPas\PastebinRecord $record
     * @param SimPas\Http\Requests\PastebinRequest $request
     * @param string $unique_id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(PastebinRecord $record, PastebinRequest $request, $unique_id)
    {
        $record = $record->where('unique_id', $unique_id)->first();
        $record->title = $request->title;
        $record->content = $request->content;

        $record->save();

        Session::flash('flash_message', 'Pastebin successfully edited');

        return redirect()->route('pastebin.show', [
            'unique_id' => $unique_id
        ]);
    }

    /**
     * Show entities for user
     *
     * @param SimPas\PastebinRecord $record
     * @return \Illuminate\Http\Response
     */
    public function entities(PastebinRecord $record)
    {
        return $record->where('user_id', Auth::id())->get();
    }
}
