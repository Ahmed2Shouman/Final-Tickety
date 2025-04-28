<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here. For now, returning true
        // Assuming that the user has permission to update a movie.
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
            'title' => 'sometimes|string|max:250', // Title is optional for update, but if provided, it should be a string with max 250 characters.
            'description' => 'sometimes|string|nullable', // Description is optional, but if provided, it should be a string.
            'genre' => 'sometimes|string|max:50', // Genre is optional, max length of 50 characters.
            'duration_minutes' => 'sometimes|integer|min:1', // Duration should be an integer greater than 0.
            'rating' => 'sometimes|string|max:10', // Rating is optional, should be a string with max length 10.
            'poster_url' => 'sometimes|url|max:250', // Poster URL is optional and should be a valid URL if provided.
            'trailer_url' => 'sometimes|url|max:250', // Trailer URL is optional and should be a valid URL if provided.
        ];
    }
}
