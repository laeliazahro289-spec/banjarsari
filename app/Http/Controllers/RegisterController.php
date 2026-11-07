<?php

namespace App\Http\Controllers;

use App\Models\Banom;
use App\Models\Member;
use App\Support\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RegisterController extends Controller
{
    public function create()
    {
        return view('register', ['banoms' => Banom::orderBy('urutan')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:120',
            'banom_id' => 'required|exists:banoms,id',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:30',
            'foto'     => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = Upload::save($request->file('foto'), 'anggota');
        }

        $member = Member::create($data + ['jabatan' => 'Anggota', 'tahun' => date('Y'), 'status' => 'pending']);

        // Langsung arahkan ke kartu anggota (alamatnya bertanda tangan, tidak bisa ditebak)
        return redirect(URL::signedRoute('daftar.kartu', ['member' => $member->id]));
    }

    public function kartu(Member $member)
    {
        $member->load('banom');

        return view('register-card', compact('member'));
    }
}
