<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', [
            'pages' => Page::orderBy('sort_order')->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.pages.form', ['page' => new Page()]);
    }

    public function store(Request $request)
    {
        $page = Page::create($this->validated($request));
        $this->audit($request, 'Tambah page', $page);

        return redirect()->route('admin.pages.index')->with('status', 'Page berhasil dibuat.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $page->update($this->validated($request, $page));
        $this->audit($request, 'Update page', $page);

        return redirect()->route('admin.pages.index')->with('status', 'Page berhasil diperbarui.');
    }

    public function destroy(Request $request, Page $page)
    {
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $this->audit($request, 'Hapus page', $page);
        $page->delete();

        return back()->with('status', 'Page berhasil dihapus.');
    }

    private function validated(Request $request, ?Page $page = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:160'],
            'slug' => ['nullable', 'string', 'max:180', Rule::unique('pages')->ignore($page)],
            'eyebrow' => ['nullable', 'string', 'max:80'],
            'hero_title' => ['nullable', 'string', 'max:180'],
            'hero_subtitle' => ['nullable', 'string', 'max:500'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string', 'min:10'],
            'template' => ['required', Rule::in(['default', 'services', 'about', 'landing'])],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cta_label' => ['nullable', 'string', 'max:80'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'show_in_nav' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'meta_title' => ['nullable', 'string', 'max:160'],
            'meta_description' => ['nullable', 'string', 'max:255'],
        ]);

        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['hero_title'] = $data['hero_title'] ?: $data['title'];
        $data['show_in_nav'] = $request->boolean('show_in_nav');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        if ($request->hasFile('featured_image')) {
            if ($page?->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }

            $data['featured_image'] = $request->file('featured_image')->store('pages', 'public');
        } else {
            unset($data['featured_image']);
        }

        return $data;
    }

    private function audit(Request $request, string $action, Page $page): void
    {
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => "{$action}: {$page->title}",
            'auditable_type' => Page::class,
            'auditable_id' => $page->id,
            'ip_address' => $request->ip(),
        ]);
    }
}
