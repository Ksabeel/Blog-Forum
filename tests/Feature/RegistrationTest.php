<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
	use RefreshDatabase;

	/** @test */
	function a_confirmation_email_is_sent_upon_registration()
	{
		Mail::fake();

		event(new Registered(create('App\User')));

		Mail::assertSent(PleaseConfirmYourEmail::class);
	}

	/** @test */
	function user_can_fully_confirm_their_email_addresses()
	{
		$this->post('/register', [
			'name' => 'Sabeel',
			'email' => 'sabeel@app.com',
			'password' => 'password',
			'password_confirmation' => 'password'
		]);

		$user = User::whereName('Sabeel')->first();

		$this->assertFalse($user->confirmed);
		$this->assertNotNull($user->confirmation_token);

		$response = $this->get('/register/confirm?token=' . $user->confirmation_token);

		$this->assertTrue($user->fresh()->confirmed);

		$response->assertRedirect('/threads');
	}
}
