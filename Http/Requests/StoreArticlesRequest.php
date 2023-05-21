<?php

namespace HexGad\Articles\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticlesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', Rule::unique('articles', 'title')],
            'slug' => ['required', Rule::unique('articles', 'slug')],
            'image' => ['required', 'image'],
            'content' => ['required'],
            'category_id' => ['nullable'],
            'form_id' => ['nullable'],
            'pixel_id' => ['nullable'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
