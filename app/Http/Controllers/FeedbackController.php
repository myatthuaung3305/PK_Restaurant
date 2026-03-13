<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:80'],
            'email' => ['required', 'email', 'max:120'],
            'phone' => ['required', 'string', 'min:8', 'max:15'],
            'message' => ['required', 'string', 'min:5', 'max:1000'],
            'promotion' => ['required', 'in:Y,N'],
            'sms' => ['nullable', 'in:Y'],
            'whatsapp' => ['nullable', 'in:Y'],
            'emailch' => ['nullable', 'in:Y'],
        ]);

        $promotion = $data['promotion'];

        Feedback::query()->create([
            'feedback_date' => now()->toDateString(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => preg_replace('/[^0-9+]/', '', $data['phone']) ?? '',
            'message' => $data['message'],
            'promotion' => $promotion,
            'channel_sms' => $promotion === 'Y' && isset($data['sms']) ? 'Y' : 'N',
            'channel_whatsapp' => $promotion === 'Y' && isset($data['whatsapp']) ? 'Y' : 'N',
            'channel_email' => $promotion === 'Y' && isset($data['emailch']) ? 'Y' : 'N',
        ]);

        return redirect()->route('home')->with('success', 'Feedback saved. Thank you for your feedback.');
    }
}