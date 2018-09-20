<?php

namespace App\Console\Commands\User;
use App\Models\User;
use Illuminate\Console\Command;

class VerifyCommand extends Command
{
    protected $signature = 'user:verify {email}';

    protected $description = 'Verify User by Email';

    public function handle()
    {
        $user = User::where('email',$this->argument('email'))->first();

        if(isset($user)){
            if (($user->status === User::STATUS_WAIT)){
                $user->status = User::STATUS_ACTIVE;
                $user->email_verified_at = now();
                $user->verify_token = null;
                $user->save();
                $this->info('Email'.$this->argument('email').' of user '.$user->name.' is verified!');
            }else{
                $this->info('User with email '.$this->argument('email').'  ferified already!');
            }
        }else{
             $this->info('User with email '.$this->argument('email').'  not found!');
        }
        return true;



    }
}
