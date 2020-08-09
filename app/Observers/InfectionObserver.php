<?php

namespace App\Observers;

use App\Mail\InfectionMail;
use App\Models\UsersXpathology;
use Illuminate\Support\Facades\Mail;

class InfectionObserver
{
    public function create(UsersXpathology $usersXpathology)
    {
        $data = [
            'user' => $usersXpathology->user->name,
            'pathology' => $usersXpathology->phatology->title,
        ];

        Mail::queue(new InfectionMail($data));
    }
}
