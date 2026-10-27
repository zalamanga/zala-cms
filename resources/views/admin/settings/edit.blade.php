@extends('layouts.admin')
@section('title', 'Site Settings')
@section('heading', 'Site Settings')
@section('content')
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    @method('PUT')
    <div class="grid gap-5 lg:grid-cols-2">
        <section class="rounded-lg border border-slate-200 p-4">
            <h2 class="mb-4 text-lg font-black">Brand</h2>
            <div class="grid gap-4">
                <label class="grid gap-2 text-sm font-bold text-slate-600">Site name <input class="rounded-lg border border-slate-300 px-3 py-2" name="site_name" value="{{ old('site_name', $settings->site_name) }}" required></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Tagline <input class="rounded-lg border border-slate-300 px-3 py-2" name="tagline" value="{{ old('tagline', $settings->tagline) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Description <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="description" rows="5">{{ old('description', $settings->description) }}</textarea></label>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 p-4">
            <h2 class="mb-4 text-lg font-black">Contact</h2>
            <div class="grid gap-4">
                <label class="grid gap-2 text-sm font-bold text-slate-600">Email <input class="rounded-lg border border-slate-300 px-3 py-2" type="email" name="contact_email" value="{{ old('contact_email', $settings->contact_email) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Phone <input class="rounded-lg border border-slate-300 px-3 py-2" name="contact_phone" value="{{ old('contact_phone', $settings->contact_phone) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Address <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="address" rows="3">{{ old('address', $settings->address) }}</textarea></label>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 p-4">
            <h2 class="mb-4 text-lg font-black">Social Links</h2>
            <div class="grid gap-4">
                <label class="grid gap-2 text-sm font-bold text-slate-600">Facebook URL <input class="rounded-lg border border-slate-300 px-3 py-2" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Instagram URL <input class="rounded-lg border border-slate-300 px-3 py-2" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">LinkedIn URL <input class="rounded-lg border border-slate-300 px-3 py-2" name="linkedin_url" value="{{ old('linkedin_url', $settings->linkedin_url) }}"></label>
            </div>
        </section>

        <section class="rounded-lg border border-slate-200 p-4">
            <h2 class="mb-4 text-lg font-black">Default SEO</h2>
            <div class="grid gap-4">
                <label class="grid gap-2 text-sm font-bold text-slate-600">Default meta title <input class="rounded-lg border border-slate-300 px-3 py-2" name="default_meta_title" value="{{ old('default_meta_title', $settings->default_meta_title) }}"></label>
                <label class="grid gap-2 text-sm font-bold text-slate-600">Default meta description <textarea class="rounded-lg border border-slate-300 px-3 py-2" name="default_meta_description" rows="4">{{ old('default_meta_description', $settings->default_meta_description) }}</textarea></label>
            </div>
        </section>
    </div>
    <div class="mt-5">
        <button class="rounded-lg bg-teal-600 px-5 py-3 font-black text-white hover:bg-teal-700">Simpan Settings</button>
    </div>
</form>
@endsection
