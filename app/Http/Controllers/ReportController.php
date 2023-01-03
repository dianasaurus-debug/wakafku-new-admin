<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $program_id = $request->program_id;
        return Inertia::render('Report/Index', [
            'program' => Program::where('id', $program_id)->first(),
            'reports' => Report::with('program')
                ->where('program_id', $program_id)
                ->get(),
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $program = Program::where('id', $request->program_id)->first();
        return Inertia::render('Report/Create', [
            'program' => $program
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
//            $request->validate([
//                'title' => 'required',
//                'desc' => 'required|string',
//                'address_detail' => 'required',
//                'cover' => 'required|image',
//                'category_id' => 'required',
//                'address_id' => 'required',
//            ]);

            $report = Report::create([
                'title' => $request->title,
                'desc' => $request->desc,
                'date_created' => Carbon::now(),
                'program_id' => $request->program_id,
                'created_by' => Auth::user()->name,
                'created_by_role' => 'Admin',
            ]);

            return redirect()->to('reports?program_id='.$request->program_id)->with('success', 'Report berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->to('reports?program_id='.$request->program_id)->with('error', 'Report gagal ditambahkan! Error : ' . $e->getMessage().' line '.$e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
