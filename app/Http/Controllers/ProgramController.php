<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Programs/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'programs' => Program::with('category')
                ->with('address')
                ->get()
                ->transform(fn ($program) => [
                    'address_detail' => $program->address_detail,
                    'id' => $program->id,
                    'title' => $program->title,
                    'terkumpul' => $program->terkumpul,
                    'address' => $program->address,
                    'desc' => $program->desc,
                    'category' => $program->category,

                ]),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Programs/Create', [
            'categories' => $categories
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
            $program = Program::create([
                'title' => $request->title,
                'desc' => $request->desc,
                'target' => $request->target,
                'address_detail' => $request->address_detail,
                'latitude' => $request->location['position']['lat'],
                'longitude' => $request->location['position']['lng'],
                'category_id' => $request->category_id,
                'address_id' => $request->address_id,
                'percentage' => 0,
                'created_by' => Auth::user()->name,
                'created_by_role' => 'Admin',
                'terkumpul' => isset($request->terkumpul) ? $request->terkumpul : 0,
                'cover' => $request->file('cover') ? $request->file('cover')->store('covers') : null,
            ]);

            return redirect()->route('programs.index')->with('success', 'Program berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->route('programs.index')->with('error', 'Program gagal ditambahkan! Error : ' . $e->getMessage().' line '.$e->getLine());
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
        $selected_program = Program::with('category')
            ->where('id', $id)
            ->with('address')
            ->first();
        $categories = Category::all();
        return Inertia::render('Programs/Edit', [
            'program' => $selected_program,
            'categories' => $categories
        ]);
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
        try {
            $request->validate([
                'title' => 'required',
                'desc' => 'required|string',
                'address_detail' => 'required',
                'category_id' => 'required',
                'address_id' => 'required',
            ]);
            $program = Program::where('id', $id)->first();
            $precentage = 0;
            if($request->target!=0){
                $precentage = $program->terkumpul != 0 ? ($program->terkumpul/$request->target) * 100 : 0;
            }
            $program->update([
                'title' => $request->title,
                'desc' => $request->desc,
                'target' => $request->target,
                'address_detail' => $request->address_detail,
                'latitude' => $request->location['position']['lat'],
                'longitude' => $request->location['position']['lng'],
                'category_id' => $request->category_id,
                'address_id' => $request->address_id,
                'created_by' => Auth::user()->name,
                'percentage' => $precentage,
                'created_by_role' => 'Admin',
                'terkumpul' => isset($request->terkumpul) ? $request->terkumpul : 0,
            ]);

            if ($request->file('cover')) {
                $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
                if (file_exists($storagePath.$program->cover)) unlink($storagePath.$program->cover);
                $program->update(['cover' => $request->file('cover')->store('covers')]);
            }

            return redirect()->route('programs.index')->with('success', 'Program berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->route('programs.index')->with('error', 'Program gagal diupdate! Error : ' . $e->getMessage().' line '.$e->getLine());
        }

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
