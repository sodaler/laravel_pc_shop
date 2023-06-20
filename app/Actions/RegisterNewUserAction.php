<?php

namespace App\Actions;

use App\Contracts\RegisterNewUserContract;
use App\DTOs\NewUserDTO;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class RegisterNewUserAction implements RegisterNewUserContract
{
    public function __invoke(NewUserDTO $data): RedirectResponse
    {
       $user = User::query()->create([
           'name' => $data->name,
           'email' => $data->email,
           'password' => bcrypt($data->password),
       ]);

       event(new Registered($user));

       auth()->login($user);

       return redirect()->intended(route('home'));
    }
}
