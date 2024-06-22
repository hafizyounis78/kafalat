<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttendRequest extends FormRequest
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
//        dd(request()->all());

        return [

                'data.*.user_id' => 'required|numeric|exists:users,id',
                'data.*.attendance_date' => 'required'
        ];

    }
}
