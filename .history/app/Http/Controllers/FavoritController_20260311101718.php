<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    /**
     * Display list of user's favorite books
     */
    public function index()
    {
        $user = Auth::user();
        $favorit = $user->bukuFavorit()->paginate(12);

        return view('peminjam.favorit.index', compact('favorit'));
    }

    /**
     * Toggle favorite status for a book
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id'
        ]);

        $user = Auth::user();
        $buku = Buku::findOrFail($request->buku_id);

        $isFavorit = $user->toggleFavorit($buku);

        // Check if request wants JSON response
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'is_favorit' => $isFavorit,
                'message' => $isFavorit ? 'Buku ditambahkan ke favorit' : 'Buku dihapus dari favorit'
            ]);
        }

        return redirect()->back()->with('success', $isFavorit ? 'Buku ditambahkan ke favorit' : 'Buku dihapus dari favorit');
    }
}

