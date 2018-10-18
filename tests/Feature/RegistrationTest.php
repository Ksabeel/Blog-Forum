<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function a_confirmation_email_is_sent_upon_registration()
	{
		Mail::fake();

		$this->post(route('register'), [
			'name' => 'Sabeel',
			'email' => 'sabeel@app.com',
			'password' => 'password',
			'password_confirmation' => 'password'
		]);

		Mail::assertSent(PleaseConfirmYourEmail::class);
	}

	/** @test */
	function user_can_fully_confirm_their_email_addresses()
	{
		Mail::fake();

		$this->post(route('register'), [
			'name' => 'Sabeel',
			'email' => 'sabeel@app.com',
			'password' => 'password',
			'password_confirmation' => 'password'
		]);

		$user = User::whereName('Sabeel')->first();

		$this->assertFalse($user->confirmed);
		$this->assertNotNull($user->confirmation_token);

		$this->get(route('register.confirm', ['token' => $user->confirmation_token]))
			->assertRedirect(route('threads'));

		tap($user->fresh(), function ($user) {
			$this->assertTrue($user->confirmed);
			$this->assertNull($user->confirmation_token);
		});
	}

	/** @test */
	function confirming_an_invalid_token()
	{
		$this->get(route('register.confirm', ['token' => 'invalid']))
			->assertRedirect(route('threads'))
			->assertSessionHas('flash', 'Unknown token.');
	}
}