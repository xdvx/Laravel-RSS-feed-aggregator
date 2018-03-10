<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Console\Commands\UserCreate;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;
use Faker;
use App\User;

class UserCreateTest extends TestCase
{
    use DatabaseMigrations;

    protected $command;
    /**
     * @var CommandTester
     */
    protected $commandTester;

    public function setUp()
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(UserCreate::class);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('user:create');
        $this->commandTester = new CommandTester($this->command);
    }

    /** @test */
    public function createUser()
    {
        $faker = Faker\Factory::create();

        $name = $faker->userName;
        $email = $faker->safeEmail;
        $pass = $faker->password;

        $inputs = [
            $name,
            $email,
            $pass,
            $pass
        ];

        $this->commandTester->setInputs($inputs);
        $this->commandTester->execute([
            'command' => $this->command->getName()
        ]);

        $this->assertDatabaseHas('users', compact('email', 'name'));
    }
}
