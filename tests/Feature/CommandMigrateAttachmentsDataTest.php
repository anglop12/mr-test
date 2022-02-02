<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommandMigrateAttachmentsDataTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_migrate_attachments_data_command()
    {
        $this->artisan('migrate_attachments_data')->doesntExpectOutput('Ha ocurrido un error en la ejecución.')->assertExitCode(0);
    }
}
