<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\News;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'jumlahBerita'  => News::count(),
            'jumlahAnggota' => Member::where('status', 'aktif')->count(),
            'jumlahPending' => Member::where('status', 'pending')->count(),
            'pending'       => Member::with('banom')->where('status', 'pending')->latest()->limit(5)->get(),
        ]);
    }
}
