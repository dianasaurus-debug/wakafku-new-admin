<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationFile;
use App\Models\Program;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class GuestController extends Controller
{
    public function landing_index(Request $request)
    {
        return Inertia::render('Landing/Index');
    }

    public function lembaga_register(Request $request)
    {
        return Inertia::render('Landing/Register');
    }

    public function lembaga_register_proses(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2,
                'status' => 'waiting'
            ]);
            $organization = Organization::create([
                'phone' => $request->phone,
                'date_created' => Carbon::now(),
                'profil_organisasi' => $request->profil_organisasi,
                'alamat_detail' => $request->alamat_detail,
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'jenis_lembaga' => $request->jenis_lembaga,
                'tahun_berdiri' => $request->tahun_berdiri,
                'website' => $request->website,
            ]);
            if ($organization != null) {
                $organization_file = OrganizationFile::create([
                    'organization_id' => $organization->id,
                    'akta_pendirian' => storeasfile($request->file('akta_pendirian'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'akta_pendirian'),
                    'company_profile' => storeasfile($request->file('company_profile'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'company_profile'),
                    'npwp' => storeasfile($request->file('npwp'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'npwp'),
                    'pengesahan_kemenkumham' => storeasfile($request->file('pengesahan_kemenkumham'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'pengesahan_kemenkumham'),
                    'rekomendasi_lkspwu' => storeasfile($request->file('rekomendasi_lkspwu'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'rekomendasi_lkspwu'),
                    'keterangan_dom' => storeasfile($request->file('keterangan_dom'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'keterangan_dom'),
                    'sertif_kompetensi' => storeasfile($request->file('sertif_kompetensi'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'sertif_kompetensi'),
                    'rencana_kerja' => storeasfile($request->file('rencana_kerja'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'rencana_kerja'),
                    'surat_permohonan' => storeasfile($request->file('surat_permohonan'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'surat_permohonan'),
                    'surat_pernyataan_diaudit' => storeasfile($request->file('surat_pernyataan_diaudit'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'surat_pernyataan_diaudit'),
                    'surat_wakaf_bulanan' => storeasfile($request->file('surat_wakaf_bulanan'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'surat_wakaf_bulanan'),
                    'surat_pelaksanaan_wakaf' => storeasfile($request->file('surat_pelaksanaan_wakaf'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'surat_pelaksanaan_wakaf'),
                    'surat_dana_operasional' => storeasfile($request->file('surat_dana_operasional'), 'berkas_lembaga/lembaga_'.$organization->id, time().'_'.'surat_dana_operasional'),
                ]);
            }
            return redirect()->to('/login')->with('success', 'Berhasil mendaftarkan Lembaga Anda, silahkan login untuk masuk ke sistem');
        } catch (\Exception $e) {
            return redirect()->to('/lembaga/daftar')->with('error', 'Gagal mendaftarkan lembaga wakaf ! Error : ' . $e->getMessage() . ' line ' . $e->getLine());
        }
    }


}
