<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Str;
use App\Models\User;
use App\Models\Instructor;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_student_registration()
    {
        $username = Str::random(10);
        $response = $this->withHeaders([
                        '/'     =>  'Application/json'
                    ])->post('/api/register', [
                        'name' => $username,
                        'email' => $username.'@example.com',
                        'password'=> 'password'
                    ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas(User::class, ['name' => $username, 'email' => $username.'@example.com']);
    }

    //registration as an instructor
    public function test_instructor_registration(){
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/api/instructor/onboarding', [
            'about' => fake()->paragraph(3),
            'sub_title' => fake()->text(20),
            'youtube_link' => fake()->url(),
            'website' => fake()->domainName(),
            'twitter_link' => fake()->url(),
            'linkedin_link' => fake()->url(),
        ]);

        $response->assertStatus(201);
    }

    //test login
    public function test_user_login(){
        $user = User::factory()->create();
        $response = $this->post('/api/login', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }
}
