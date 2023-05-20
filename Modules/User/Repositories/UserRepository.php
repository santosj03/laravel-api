<?php

namespace Modules\User\Repositories;

use Carbon\Carbon;
use App\Jobs\SendEmailJob;
use App\Base\BaseRepository;
use Modules\User\Entities\User;
use Modules\User\Entities\UserAccessStatus;
 
class UserRepository extends BaseRepository 
{
    public function model()
    {
        return User::class;
    }

    public function createNewUser($payload)
    {
        $user = $this->model->create([
        	'name' => $payload['name'],
        	'email' => $payload['email'],
        	'password' => bcrypt($payload['password'])
        ]);

        return $user->details()->create([
            'user_id' => $user->id,
            'first_name' => $payload['first_name'],
            'last_name' => $payload['last_name']
        ]);
    }

    public function findUser($id)
    {
        return $this->model->with('details', 'status')
            ->whereId($id)
            ->first();
    }

    public function handleAttemps($email)
    {
        if($user = $this->model->whereEmail($email)->first()){
            ++$user->login_attempts;
            $user->save();

            if($user->login_attempts >= 3){
                $user->locked_until = Carbon::now()->addDays(1)->toDateTimeString();
                $user->	user_access_status_id = UserAccessStatus::whereName('Locked')->first()->id;
                $user->save();

                $details['email'] = $user->email;
                SendEmailJob::dispatch($details)->onQueue('queue-notification')->delay(360);
            }
        }
    }
}