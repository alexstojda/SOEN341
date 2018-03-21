<?php

    namespace Tests\Browser;

    use App\User;
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Laravel\Dusk\Browser;
    use Tests\DuskTestCase;

    class LoginTest extends DuskTestCase {
        use DatabaseMigrations;

        /**
         * A Dusk test example.
         *
         * @return void
         * @throws \Throwable
         */
        public function testLogin(): void {
            $user = factory(User::class)->create();
            $this->assertDatabaseHas('users', ['email' => $user->email]);

            $this->browse(function(Browser $browser) use ($user) {

                $browser->visit('/login')
                    ->resize(1920, 1080)
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->screenshot('login-0')
                    ->press('Login')
                    ->screenshot('login-1')
                    ->assertPathIs('/questions');
            });
        }

        /**
         * Tests the ui flow of loggining in via facebook
         * @throws \Throwable
         */
        public function testFBlogin() : void {
            $email = 'soen341fbauth@kdypro.com';

            //$user = factory(User::class)->create();
            $this->assertDatabaseMissing('users', ['email' => $email]);

            $this->browse(function(Browser $browser) use ($email) {

                $browser->visit('/login')
                    ->resize(1920, 1080)
                    ->clickLink('Login with Facebook')
                    ->screenshot('fb-0')
                    ->assertPathBeginsWith('/login.php')
                    ->type('email', $email)
                    ->type('pass', 'a123123a')
                    ->screenshot('fb-1')
                    ->press('Log In');

                //ONLY FOR FIRST ACCOUNT LOGIN
                    //->press('Continue As John')
                    //->screenshot('fb-3');

                $browser->assertPathIs('/questions')
                    ->screenshot('fb-2')
                    ->assertSee('John Smith');
                //$this->assertDatabaseHas('users', ['email' => $email]);
            });
        }

        /**
         * A Dusk test example.
         *
         * @return void
         * @throws \Throwable
         */
        public function testRegister(): void {
            $user = factory(User::class)->make();
            $this->assertDatabaseMissing('users', ['email' => $user->email]);

            $this->browse(function(Browser $browser) use ($user) {
                $browser->visit('/register')
                    ->resize(1920, 1080)
                    ->type('name', $user->name)
                    ->type('email', $user->email)
                    ->type('password', 'secret')
                    ->type('password_confirmation', 'secret')
                    ->screenshot('register-0')
                    ->press('Register')
                    ->screenshot('register-1')
                    ->assertPathIs('/questions');
            });
        }
    }
