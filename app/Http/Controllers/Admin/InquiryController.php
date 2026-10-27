<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $domain = app(Domain::class);
        $query = Inquiry::forDomain($domain)->latest();

        if ($type = $request->query('type')) {
            $query->where('type', $type);
        }

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $inquiries = $query->paginate(15);

        return view('admin.inquiries.index', compact('inquiries', 'domain'));
    }

    public function show(Inquiry $inquiry): View
    {
        $domain = app(Domain::class);
        return view('admin.inquiries.show', compact('inquiry', 'domain'));
    }

    public function updateStatus(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $status = $request->validate([
            'status' => 'required|in:new,in_progress,contacted,resolved,closed',
        ])['status'];

        $inquiry->update(['status' => $status]);

        return back()->with('success', "Inquiry status updated to '$status'.");
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
