<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Tests\RequestFactories\SignInFormRequestFactory;
use Worksome\RequestFactories\Concerns\HasFactory;
use function auth;

class SignInFormRequest extends FormRequest
{
    use HasFactory;

    public static string $factory = SignInFormRequestFactory::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email:dns'],
            'password' => ['required'],
        ];
    }
}
