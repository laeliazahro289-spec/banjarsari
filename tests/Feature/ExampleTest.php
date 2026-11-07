<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_halaman_login_dapat_dibuka(): void
    {
        $this->get('/login')->assertStatus(200);
    }
}
