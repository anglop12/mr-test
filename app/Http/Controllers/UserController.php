<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', ['users' => $users]);
    }

    public function index_fast_polimorfica()
    {
        if (Schema::hasTable('attachments')) {
            $users = User::with(['posts.attachments', 'posts.comments.attachments'])->get();
            return view('index_fast_polimorfica', ['users' => $users]);
        } else {
            $users = User::with(['posts.post_attachments', 'posts.comments.comment_attachments'])->get();
            return view('index_fast_relacional', ['users' => $users]);
        }

    }

    public function index_fast_relacional()
    {
        $users = User::with(['posts.post_attachments', 'posts.comments.comment_attachments'])->get();
        return view('index_fast_relacional', ['users' => $users]);
    }
}
