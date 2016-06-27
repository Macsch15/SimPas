<?php

namespace SimPas\Http\Requests;

use SimPas\Http\Requests\Request;

class PastebinRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            'content' => sprintf('required|max:%d', config('pastebin.max_content_length')),
            'g-recaptcha-response' => 'required|recaptcha'
        ];
    }
}
