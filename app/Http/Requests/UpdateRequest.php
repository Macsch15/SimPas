<?php

namespace SimPas\Http\Requests;

use SimPas\Http\Requests\Request;
use Auth;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => sprintf('required|max:%d', config('pastebin.max_title_length')),
            'content' => sprintf('required|max:%d', config('pastebin.max_content_length'))
        ];
    }
}
