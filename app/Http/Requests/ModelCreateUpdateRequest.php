<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelCreateUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(\Auth::user() && \Auth::user()->isAdmin())
            return true;
        else
            return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:5|max:100',
            'short_body' => 'required|max:255',
            'body' => 'required',
            'slug' => 'required|regex:/(^([a-zA-Z0-9-_]+)(\d+)?$)/u|unique:posts,slug,'. $this->post->id,
            'published' => 'required',
            'tags' => '',
        ];
    }
}
