<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        if (!Schema::hasTable('users') and !Schema::hasTable('posts') and !Schema::hasTable('comments') and !Schema::hasTable('comment_attachments') and !Schema::hasTable('post_attachments')) {
            $this->artisan('migrate --seed')->assertExitCode(0);
        }

        return $app;
    }
}
