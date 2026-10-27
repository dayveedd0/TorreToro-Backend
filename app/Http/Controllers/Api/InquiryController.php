<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmissionAlert;
use App\Models\Domain;
use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'nullable|string|in:general_contact,expert_appointment,consultation',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'service_requested' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:5000',
            'preferred_date' => 'nullable|string|max:50',
        ]);

        $domain = app(Domain::class);
        $validated['domain_id'] = $domain->id;

        $inquiry = Inquiry::create($validated);

        // Send email alert to kater@torretoro.com from hello@torretoro.com
        $recipient = env('MAIL_CONTACT_RECIPIENT', 'kater@torretoro.com');
        try {
            Mail::to($recipient)->send(new ContactFormSubmissionAlert($inquiry, $domain));
        } catch (\Throwable $e) {
            Log::error("Failed to send contact inquiry email notification: " . $e->getMessage(), [
                'inquiry_id' => $inquiry->id,
                'recipient' => $recipient,
            ]);
        }

        return response()->json([
            'message' => 'Inquiry received successfully. Our team will contact you shortly.',
            'data' => $inquiry,
        ], 201);
    }
}
