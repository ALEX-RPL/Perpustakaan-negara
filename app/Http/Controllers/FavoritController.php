<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
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
        $favorit = $user->bukuFavorit()->get();

        return view('peminjam.favorit.index', compact('favorit'));
    }

    /**
     * Display all favorite books (admin view)
     */
    public function adminIndex(Request $request)
    {
        $search = $request->get('search');
        
        $users = User::whereHas('bukuFavorit', function($q) {
            $q->whereNotNull('buku_id');
        })
        ->with('bukuFavorit')
        ->when($search, function($query) use ($search) {
            $query->whereHas('bukuFavorit', function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        })
        ->paginate(10);
        
        return view('admin.favorit.index', compact('users', 'search'));
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

        // Always return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'is_favorit' => $isFavorit,
                'message' => $isFavorit ? 'Buku ditambahkan ke favorit' : 'Buku dihapus dari favorit'
            ]);
        }

        return redirect()->back()->with('success', $isFavorit ? 'Buku ditambahkan ke favorit' : 'Buku dihapus dari favorit');
    }
}

