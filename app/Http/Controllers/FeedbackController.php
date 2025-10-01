<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'pesan' => 'required|string|max:1000',
        ]);

        $feedback = Feedback::create([
            'type' => $request->type,
            'buku_id' => $request->buku_id,
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'rating' => $request->rating,
            'pesan' => $request->pesan
        ]);

        return redirect()->back()->with(
            $request->type === 'website' ? 'success_website' : 'success_buku',
            'Terima kasih! Feedback Anda telah tersimpan.'
        );
    }
}
