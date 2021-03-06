<?php 

/*
 * User: Juris Tetarenko
 */

namespace Blog\Api\Requests;

/**
 * Class EditEmailRequest
 * @package Blog\Api\Requests
 */
class EditEmailRequest extends BaseRequest
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
            'email' => 'required|confirmed|email|max:255|unique:users',
        ];
    }
}