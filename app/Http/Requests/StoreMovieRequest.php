<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer',
            'genre' => 'nullable|string|max:50',
            'rating' => 'nullable|string|max:10',
            'poster_url' => 'nullable|string|max:255',
            'trailer_url' => 'nullable|string|max:255',
        ];
    }
}
