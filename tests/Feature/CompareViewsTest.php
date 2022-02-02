<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CompareViewsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_compare_views_index_to_index_fast_relacional()
    {
        $odlView = $this->view('index', ['users' => User::all()]);
        $odlView->assertSee('Attachments');
        $odlView->assertSee('Comments');
        $odlView->assertSee('Comment Attachments');
        $odlView->assertSee('13');
        $odlView->assertSee('10');
        $odlView->assertSee('170');

        $OldViewData = (string) $this->view('index', ['users' => User::all()]);
        $compareOldViewData = strip_tags($OldViewData);

        $newView = $this->view('index_fast_relacional', ['users' => User::with(['posts.post_attachments', 'posts.comments.comment_attachments'])->get()]);
        $newView->assertSee('Attachments');
        $newView->assertSee('Comments');
        $newView->assertSee('Comment Attachments');
        $newView->assertSee('13');
        $newView->assertSee('10');
        $newView->assertSee('170');

        $newView->assertSeeText($compareOldViewData);
    }

    public function test_compare_views_index_to_index_fast_polimorfica()
    {
        $odlView = $this->view('index', ['users' => User::all()]);
        $odlView->assertSee('Attachments');
        $odlView->assertSee('Comments');
        $odlView->assertSee('Comment Attachments');
        $odlView->assertSee('13');
        $odlView->assertSee('10');
        $odlView->assertSee('170');

        $OldViewData = (string) $this->view('index', ['users' => User::all()]);
        $compareOldViewData = strip_tags($OldViewData);

        $newView = $this->view('index_fast_polimorfica', ['users' => User::with(['posts.attachments', 'posts.comments.attachments'])->get()]);
        $newView->assertSee('Attachments');
        $newView->assertSee('Comments');
        $newView->assertSee('Comment Attachments');
        $newView->assertSee('13');
        $newView->assertSee('10');
        $newView->assertSee('170');

        $newView->assertDontSeeText($compareOldViewData);
    }
}
