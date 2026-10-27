<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'pages' => Page::where('status', 'published')->orderBy('sort_order')->take(4)->get(),
            'posts' => Post::where('status', 'published')->latest('published_at')->take(3)->get(),
        ]);
    }

    public function page(Page $page)
    {
        abort_unless($page->status === 'published', 404);

        return view('public.page', compact('page'));
    }

    public function news()
    {
        return view('public.news.index', [
            'posts' => Post::where('status', 'published')->latest('published_at')->paginate(9),
        ]);
    }

    public function post(Post $post)
    {
        abort_unless($post->status === 'published', 404);

        return view('public.post', compact('post'));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        ContactMessage::create($validated);

        return back()->with('status', 'Pesan berhasil dikirim. Admin akan melihatnya di dashboard.');
    }
}
