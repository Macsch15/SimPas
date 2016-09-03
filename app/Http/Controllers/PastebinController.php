<?php

namespace SimPas\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use SimPas\Http\Requests\StoreRequest;
use SimPas\Http\Requests\UpdateRequest;
use SimPas\Repository\PastebinRecord;

class PastebinController extends Controller
{
    /**
     * Create pastebin.
     *
     * @param SimPas\PastebinRecord             $record
     * @param SimPas\Http\Requests\StoreRequest $request
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(PastebinRecord $record, StoreRequest $request)
    {
        $record->unique_id = str_random(15);
        $record->user_id = Auth::guest() ? 0 : Auth::id();
        $record->title = $request->title;
        $record->content = $request->content;
        $record->disable_syntax_highlighting = $request->has('disable_syntax_highlighting');
        $record->is_private = $request->has('visibility.private');

        $record->save();

        return redirect()->route('pastebin.show', [
            'unique_id' => $record->find($record->id)['unique_id'],
        ]);
    }

    /**
     * Show pastebin.
     *
     * @param SimPas\PastebinRecord $record
     * @param string                $unique_id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(PastebinRecord $record, $unique_id)
    {
        $record = $record->where('unique_id', $unique_id)->first();

        return view('pastebin.show')
            ->withEntity($record);
    }

    /**
     * Delete pastebin.
     *
     * @param SimPas\PastebinRecord $record
     * @param string                $unique_id
     *
     * @throws \Exception
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function delete(PastebinRecord $record, $unique_id)
    {
        $entity = $record->where('unique_id', $unique_id)->first();
        $entity->delete();

        return redirect('/')
            ->with('flash_message', trans('pastebin.successfully_deleted'));
    }

    /**
     * Show edit form.
     *
     * @param SimPas\PastebinRecord $record
     * @param string                $unique_id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PastebinRecord $record, $unique_id)
    {
        $record = $record->where('unique_id', $unique_id)->first();

        return view('pastebin.edit')
            ->withEntity($record)
            ->withUniqueId($unique_id);
    }

    /**
     * Update pastebin record in the database.
     *
     * @param SimPas\PastebinRecord              $record
     * @param SimPas\Http\Requests\UpdateRequest $request
     * @param string                             $unique_id
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(PastebinRecord $record, UpdateRequest $request, $unique_id)
    {
        $record = $record->where('unique_id', $unique_id)->first();
        $record->title = $request->title;
        $record->content = $request->content;

        $record->save();

        return redirect()->route('pastebin.show', [
            'unique_id' => $unique_id,
        ])->with('flash_message', trans('pastebin.successfully_edited'));
    }

    /**
     * Show last activity.
     *
     * @param SimPas\PastebinRecord $record
     *
     * @return \Illuminate\Http\Response
     */
    public function activity(PastebinRecord $record)
    {
        $record = $record
            ->where('is_private', false)
            ->orderBy('created_at', 'desc')
            ->paginate(config('pastebin.activity_results_per_page'));

        return view('pastebin.activity')
            ->withEntity($record);
    }

    /**
     * Show entities for user.
     *
     * @param SimPas\PastebinRecord $record
     *
     * @return \Illuminate\Http\Response
     */
    public function entities(PastebinRecord $record)
    {
        //
    }
}
