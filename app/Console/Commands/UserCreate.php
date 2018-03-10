<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates new admin user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Asks and validates input
     *
     * @param string $ask
     * @param string $inputName
     * @param string $rules
     * @param string $confirmation
     * @return string|bool
     */
    private function askValidated($ask, $inputName, $rules = '', $confirmation = null)
    {
        $input = $this->ask($ask);


        $inputData = [$inputName => $input];

        if ($confirmation) {
            $inputData[$inputName . '_confirmation'] = $confirmation;
        }

        $validator = Validator::make(
            $inputData,
            [$inputName => $rules]
        );
        if ($validator->fails()) {
            $messages = $validator->errors()->getMessages();

            foreach ($messages[$inputName] as $message) {
                $this->error($message);
            }

            if (! $confirmation) {
                return $this->askValidated($ask, $inputName, $rules, $confirmation);
            } else {
                return false;
            }
        }

        return $input;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->askValidated('Please enter your name:',  'name');
        $email = $this->askValidated('Please enter your email:',  'email', 'email|unique:users,email');

        do {
            $password = $this->askValidated('Please enter your password:', 'password', 'min:6');
            $passwordConfirm = $this->askValidated('Please confirm your password:', 'password', 'confirmed', $password);
        } while ($passwordConfirm === false);


        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
