<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHtaitPait extends FormRequest
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
            // 'zerohtait' => 'required_without_all',
            'amount'=>'required|gt:0|numeric'
        ];
    }

    public function messages()
    {
        return [
            // 'zerohtait.required_without_all' => 'အနည်းဆုံးတစ်ခုရွေးပေးပါ',
            'amount.required' => 'ထိုးမည့် Amount ကိုဖြည့်သွင်းပါ'
        ];
    }
}
