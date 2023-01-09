<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Report;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function all_programs(Request $request)
    {
        try {
            if (isset($request->latawal) && isset($request->longawal)) {
                if (request()->query('keyword')) {
                    $all_programs = Program::where('title', 'like', '%' . request()->query('keyword') . '%')
                        ->orWhere('alamat_detail', 'like', '%' . request()->query('keyword') . '%')
                        ->where('status', 'approved')
                        ->with('category')
                        ->get();
                } else {
                    $all_programs = Program::with('category')
                        ->where('status', 'approved')
                        ->get();
                }

                $i = 0;
                $latawal = (float)$request->latawal;
                $longawal = (float)$request->longawal;
                foreach ($all_programs as $item) {
                    $theta = $longawal - (float)$item->longitude;
                    $miles = (sin(deg2rad($latawal)) * sin(deg2rad((float)$item->latitude))) +
                        (cos(deg2rad($latawal)) * cos(deg2rad((float)$item->latitude)) * cos(deg2rad($theta)));
                    $miles = acos($miles);
                    $miles = rad2deg($miles);
                    $miles = $miles * 60 * 1.1515;
                    $kilometers = $miles * 1.609344;
                    $all_programs[$i]['distance'] = $kilometers;
                    $i++;
                }
            } else {
                if (request()->query('keyword')) {
                    $all_programs = Program::where('title', 'like', '%' . request()->query('keyword') . '%')
                        ->orderBy('title')
                        ->with('category')
                        ->get();
                } else {
                    $all_programs = Program::with('category')
                        ->orderBy('title')
                        ->get();
                }

                $i = 0;
                foreach ($all_programs as $item) {
                    $all_programs[$i]['distance'] = null;
                    $i++;
                }
            }
            $data = array(
                'status' => 'success',
                'message' => 'Berhasil menampilkan data program',
                'data' => $all_programs,
            );
            return response()->json($data);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : ' . $exception->getMessage()
                ]
            );
            return response()->json($data);
        }
    }

    public function program_route(Request $request)
    {
        try {
            $all_programs = Program::with('category')
                ->get();
            $data = array(
                'status' => 'success',
                'message' => 'Berhasil menampilkan data program',
                'data' => $all_programs,
            );
            return response()->json($data);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : ' . $exception->getMessage()
                ]
            );
            return response()->json($data);
        }
    }

    public function all_programs_by_category(Request $request, $id)
    {
        try {
            if (isset($request->latawal) && isset($request->longawal)) {
                $all_programs = Program::with('category')
                    ->where('category_id', $id)
                    ->get();
                $i = 0;
                $latawal = (float)$request->latawal;
                $longawal = (float)$request->longawal;
                foreach ($all_programs as $item) {
                    $theta = $longawal - (float)$item->longitude;
                    $miles = (sin(deg2rad($latawal)) * sin(deg2rad((float)$item->latitude))) +
                        (cos(deg2rad($latawal)) * cos(deg2rad((float)$item->latitude)) * cos(deg2rad($theta)));
                    $miles = acos($miles);
                    $miles = rad2deg($miles);
                    $miles = $miles * 60 * 1.1515;
                    $kilometers = $miles * 1.609344;
                    $all_programs[$i]['distance'] = $kilometers;
                    $i++;
                }
            } else {
                $all_programs = Program::with('category')
                    ->where('category_id', $id)
                    ->orderBy('title')
                    ->get();
                $i = 0;
                foreach ($all_programs as $item) {
                    $all_programs[$i]['distance'] = null;
                    $i++;
                }
            }
            $data = array(
                'status' => 'success',
                'message' => 'Berhasil menampilkan data program',
                'data' => $all_programs,
            );
            return response()->json($data);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : ' . $exception->getMessage()
                ]
            );
            return response()->json($data);
        }
    }

    public function get_reports(Request $request, $id)
    {
        try {
            $reports = Report::where('program_id', $id)->get();

            $data = array(
                'success' => true,
                'message' => 'Berhasil menampilkan data report',
                'data' => $reports,
            );
            return response()->json($data);
        } catch (\Exception $exception) {
            $data = array(
                [
                    'status' => 'error',
                    'message' => 'Terjadi kesalahan : ' . $exception->getMessage()
                ]
            );
            return response()->json($data);
        }
    }

}
