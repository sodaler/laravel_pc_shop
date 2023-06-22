<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Tests\RequestFactories\SignUpFormRequestFactory;
use Worksome\RequestFactories\Concerns\HasFactory;
use function auth;
use function str;

class SignUpFormRequest extends FormRequest
{
    use HasFactory;

    public static string $factory = SignUpFormRequestFactory::class;

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
            'name' => ['required', 'string', 'min:1'],
            'email' => ['required', 'email:dns', 'unique:users'],
            'password' => ['required', 'confirmed', Password::default()],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'email' => str(request('email'))
                ->squish()
                ->lower()
                ->value()
        ]);
    }
}
