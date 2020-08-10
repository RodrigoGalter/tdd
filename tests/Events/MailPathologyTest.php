<?php

namespace Tests\Events;

use App\Mail\InfectionMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class MailPathologyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMailPathology()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();

        $data = [
            'user' => 'John Doe',
            'pathology' => 'Pathology'
        ];

        Mail::assertSent(new InfectionMail($data));
    }
}
