<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Inquiry;
use App\Models\Page;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $domain = app(Domain::class);
        $domains = Domain::where('is_active', true)->get();

        $stats = [
            'inquiries_new' => Inquiry::forDomain($domain)->where('status', 'new')->count(),
            'inquiries_total' => Inquiry::forDomain($domain)->count(),
            'services_count' => Service::forDomain($domain)->count(),
            'projects_count' => Project::forDomain($domain)->count(),
            'posts_count' => Post::forDomain($domain)->count(),
            'pages_count' => Page::forDomain($domain)->count(),
        ];

        $recentInquiries = Inquiry::forDomain($domain)->latest()->limit(5)->get();
        $recentProjects = Project::forDomain($domain)->with('category')->latest()->limit(4)->get();
        $recentPosts = Post::forDomain($domain)->latest()->limit(4)->get();

        return view('admin.dashboard', compact('domain', 'domains', 'stats', 'recentInquiries', 'recentProjects', 'recentPosts'));
    }

    public function switchDomain(Request $request): RedirectResponse
    {
        $code = $request->validate(['code' => 'required|exists:domains,code'])['code'];
        return $this->applyDomainSwitch($code, $request);
    }

    public function switchDomainGet(string $code, Request $request): RedirectResponse
    {
        if (! Domain::where('code', $code)->where('is_active', true)->exists()) {
            return back()->with('error', "Invalid domain code.");
        }

        return $this->applyDomainSwitch($code, $request);
    }

    protected function applyDomainSwitch(string $code, Request $request): RedirectResponse
    {
        session(['admin_domain_code' => $code]);
        session()->save();

        // Also clean up any ?domain=... parameter in the referer so it redirects to the clean page
        $referer = $request->header('referer') ?: route('admin.dashboard');
        $cleanUrl = preg_replace('/([?&])domain=[^&]+(&|$)/', '$1', $referer);
        $cleanUrl = rtrim($cleanUrl, '?&');

        return redirect($cleanUrl)
            ->with('success', "Active domain switched to: " . strtoupper($code))
            ->withCookie(cookie('admin_domain_code', $code, 60 * 24 * 30));
    }
}
