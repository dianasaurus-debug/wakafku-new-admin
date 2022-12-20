<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function getProvinces(Request $request) {
        $data = Wilayah::select('provinsi')->distinct()->get();
        return response()
            ->json([
                'success' => true,
                'message' => 'Berhasil menampilkan provinsi!',
                'data' => $data
            ]);
    }

    public function getCities(Request $request) {
        $province = $request->provinsi;
        $data = Wilayah::where('provinsi',$province)
            ->select('jenis','kabupaten','provinsi')
            ->distinct()
            ->get();
        return response()
            ->json([
                'success' => true,
                'message' => 'Berhasil menampilkan kota!',
                'data' => $data
            ]);

    }

    public function getDistricts(Request $request) {
        $province = $request->provinsi;
        $city = $request->kabupaten;
        $type = $request->jenis;

        $data = Wilayah::where('provinsi',$province)
            ->where('kabupaten', $city)
            ->where('jenis', $type)
            ->select('kecamatan','kabupaten','jenis','provinsi')
            ->distinct()
            ->get();
        return response()
            ->json([
                'success' => true,
                'message' => 'Berhasil menampilkan kecamatan!',
                'data' => $data
            ]);
    }

    public function getVillages(Request $request) {
        $province = $request->provinsi;
        $city = $request->kabupaten;
        $type = $request->jenis;
        $district = $request->kecamatan;

        $data = Wilayah::where('provinsi',$province)
            ->where('kabupaten', $city)
            ->where('jenis', $type)
            ->where('kecamatan', $district)
            ->select('id','kelurahan','kecamatan','kabupaten','jenis','provinsi')
            ->distinct()
            ->get();
        return response()
            ->json([
                'success' => true,
                'message' => 'Berhasil menampilkan desa!',
                'data' => $data
            ]);
    }

    public function getPostalcodes(Request $request) {
        $province = $request->provinsi;
        $city = $request->kabupaten;
        $type = $request->jenis;
        $district = $request->kecamatan;
        $village = $request->kelurahan;

        $data = Wilayah::where('provinsi',$province)
            ->where('kabupaten', $city)
            ->where('jenis', $type)
            ->where('kecamatan', $district)
            ->where('kelurahan', $village)
            ->select('id','kodepos','kelurahan','kecamatan','kabupaten','jenis','provinsi')
            ->distinct()
            ->first();
        return response()
            ->json([
                'success' => true,
                'message' => 'Berhasil menampilkan kode pos!',
                'data' => $data
            ]);
    }
}
