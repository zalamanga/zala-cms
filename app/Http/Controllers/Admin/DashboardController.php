<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\ContactMessage;
use App\Models\Page;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'stats' => [
                'Pages' => Page::count(),
                'Published Posts' => Post::where('status', 'published')->count(),
                'Unread Messages' => ContactMessage::where('status', 'unread')->count(),
                'Admin Users' => User::count(),
            ],
            'contentHealth' => [
                'Draft Pages' => Page::where('status', 'draft')->count(),
                'Published Pages' => Page::where('status', 'published')->count(),
                'Draft Posts' => Post::where('status', 'draft')->count(),
                'Published Posts' => Post::where('status', 'published')->count(),
            ],
            'recentPages' => Page::latest()->take(5)->get(),
            'recentPosts' => Post::latest()->take(5)->get(),
            'recentMessages' => ContactMessage::latest()->take(5)->get(),
            'auditLogs' => AuditLog::with('user')->latest()->take(8)->get(),
        ]);
    }
}
