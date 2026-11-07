<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banom;
use App\Models\Member;
use App\Support\Upload;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $query = Member::with('banom')->latest();

        if ($request->filled('banom_id')) {
            $query->where('banom_id', $request->banom_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        return view('admin.members.index', [
            'members' => $query->paginate(15)->withQueryString(),
            'banoms'  => Banom::orderBy('urutan')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.members.edit', [
            'member' => new Member(['jabatan' => 'Anggota', 'tahun' => date('Y'), 'status' => 'aktif']),
            'banoms' => Banom::orderBy('urutan')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = Upload::save($request->file('foto'), 'anggota');
        }

        Member::create($data);

        return redirect()->route('admin.members.index')->with('ok', 'Anggota ditambahkan.');
    }

    public function edit(Member $member)
    {
        return view('admin.members.edit', [
            'member' => $member,
            'banoms' => Banom::orderBy('urutan')->get(),
        ]);
    }

    public function update(Request $request, Member $member)
    {
        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            if ($member->foto) {
                Upload::delete($member->foto);
            }
            $data['foto'] = Upload::save($request->file('foto'), 'anggota');
        }

        $member->update($data);

        return redirect()->route('admin.members.index')->with('ok', 'Data anggota diperbarui.');
    }

    public function destroy(Member $member)
    {
        if ($member->foto) {
            Upload::delete($member->foto);
        }
        $member->delete();

        return redirect()->route('admin.members.index')->with('ok', 'Anggota dihapus.');
    }

    public function approve(Member $member)
    {
        $member->update(['status' => 'aktif']);

        return back()->with('ok', $member->nama . ' disetujui sebagai anggota.');
    }

    public function card(Member $member)
    {
        $member->load('banom');

        return view('card', compact('member'));
    }

    private function validated(Request $request): array
    {
        $d = $request->validate([
            'banom_id' => 'required|exists:banoms,id',
            'nama'     => 'required|string|max:120',
            'jabatan'  => 'nullable|string|max:60',
            'alamat'   => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:30',
            'tahun'    => 'nullable|digits:4',
            'status'   => 'nullable|in:pending,aktif',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $d['jabatan'] = $d['jabatan'] ?: 'Anggota';
        $d['status'] = $d['status'] ?? 'aktif';
        unset($d['foto']);

        return $d;
    }
}
