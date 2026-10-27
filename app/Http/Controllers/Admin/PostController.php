<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', ['posts' => Post::latest()->paginate(10)]);
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post()]);
    }

    public function store(Request $request)
    {
        $post = Post::create($this->validated($request));
        $this->audit($request, 'Tambah artikel', $post);

        return redirect()->route('admin.posts.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $post->update($this->validated($request, $post));
        $this->audit($request, 'Update artikel', $post);

        return redirect()->route('admin.posts.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Request $request, Post $post)
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }

        $this->audit($request, 'Hapus artikel', $post);
        $post->delete();

        return back()->with('status', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('posts')->ignore($post)],
            'category' => ['required', 'string', 'max:80'],
            'excerpt' => ['required', 'string', 'min:10', 'max:500'],
            'content' => ['required', 'string', 'min:10'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('cover_image')) {
            if ($post?->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }

            $data['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        } else {
            unset($data['cover_image']);
        }

        return $data;
    }

    private function audit(Request $request, string $action, Post $post): void
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => "{$action}: {$post->title}",
            'auditable_type' => Post::class,
            'auditable_id' => $post->id,
            'ip_address' => $request->ip(),
        ]);
    }
}
