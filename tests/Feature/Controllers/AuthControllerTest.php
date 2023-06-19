<?php

namespace Tests\Feature\Controllers;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Auth\SignUpController;
use App\Http\Requests\SignInFormRequest;
use App\Http\Requests\SignUpFormRequest;
use App\Listeners\SendEmailNewUserListener;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Database\Factories\UserFactory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

//    /**
//     * A basic test example.
//     *
//     * @return void
//     */
//    public function test_the_application_returns_a_successful_response()
//    {
//        $response = $this->get('/');
//
//        $response->assertStatus(200);
//    }

    public function test_it_login_page_success(): void
    {
        $this->get(action([SignInController::class, 'page']))
            ->assertOk()
            ->assertSee('Вход в аккаунт')
            ->assertViewIs('auth.login');
    }

    public function test_it_sign_up_page_success(): void
    {
        $this->get(action([SignUpController::class, 'page']))
            ->assertOk()
            ->assertSee('Регистрация')
            ->assertViewIs('auth.sign-up');
    }

    public function test_it_forgot_page_success(): void
    {
        $this->get(action([ForgotPasswordController::class, 'page']))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_it_sign_in_success(): void
    {
        $password = 'hello123';

        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
            'password' => bcrypt($password)
        ]);

        $request = SignInFormRequest::factory()->create([
            'email' => $user->email,
            'password' => $password
        ]);

        $response = $this->post(action([SignInController::class, 'handle']), $request);
        $response->assertValid()
            ->assertRedirect(route('home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_it_logout_success(): void
    {
        $user = UserFactory::new()->create([
            'email' => 'testing@mail.ru',
        ]);

        $this->actingAs($user)
            ->delete(action([SignInController::class, 'logout']));
        $this->assertGuest();
    }

    public function test_it_sign_up_success(): void
    {
        Event::fake();
        Notification::fake();

        $request = SignUpFormRequest::factory()->create([
            'email' => 'testing@mail.ru',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => $request['email']
        ]);

        $response = $this->post(
            action([SignUpController::class, 'handle']),
            $request
        );

        $response->assertValid();

        $this->assertDatabaseHas('users', [
            'email' => $request['email']
        ]);

        /* @var Authenticatable $user */
        $user = User::query()->where(['email' => $request['email']])->first();

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendEmailNewUserListener::class);

        $event = new Registered($user);
        $listener = new SendEmailNewUserListener();
        $listener->handle($event);

        Notification::assertSentTo($user, NewUserNotification::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('home'));
    }
}
