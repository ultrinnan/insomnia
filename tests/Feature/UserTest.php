<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function testXmlResponse()
    {
        $response = $this->get('/users/xml');

        $response->assertStatus(200);
        $this->assertSame('text/xml', $response->headers->get('content-type'));
    }
}



