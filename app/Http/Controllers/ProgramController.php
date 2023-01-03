<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Organization;
use App\Models\Program;
use App\Models\ProgramFile;
use App\Models\Role;
use App\Notifications\ApproveProgram;
use App\Notifications\RejectProgram;
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
        $organization = null;
        if(Auth::user()->role_id==1){
            $program = Program::with('category')
                ->with('address')
                ->get();
        } else {
            $organization = Organization::where('user_id', Auth::id())->first();
            $program = Program::with('category')
                ->with('address')
                ->where('organization_id', $organization->id)
                ->get();
        }
        return Inertia::render('Programs/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search'),
            'organization' => $organization,
            'programs' => $program

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
            $recent_role = Role::where('id', Auth::user()->role_id)->first();
            $organization = Organization::where('user_id', Auth::id())->first();
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
                'created_by_role' => $recent_role->name,
                'status' => $organization !=null ? 'waiting' : 'approved',
                'organization_id' => $organization !=null ? $organization->id : null,
                'terkumpul' => isset($request->terkumpul) ? $request->terkumpul : 0,
                'cover' => $request->file('cover') ? $request->file('cover')->store('covers') : null,
            ]);
            if($organization!=null){
                $program_file = ProgramFile::create([
                    'program_id' => $program->id,
                    'surat_permohonan_wakaf'=> storeasfile($request->file('surat_permohonan_wakaf'), 'berkas_lembaga/lembaga_'.$organization->id.'/program_wakaf/program_wakaf_'.$program->id, time().'_'.'surat_permohonan_wakaf'),
                    'surat_pendaftaran_wakaf'=> storeasfile($request->file('surat_pendaftaran_wakaf'), 'berkas_lembaga/lembaga_'.$organization->id.'/program_wakaf/program_wakaf_'.$program->id, time().'_'.'surat_pendaftaran_wakaf'),
                    'ikrar_wakaf'=> storeasfile($request->file('ikrar_wakaf'), 'berkas_lembaga/lembaga_'.$organization->id.'/program_wakaf/program_wakaf_'.$program->id, time().'_'.'ikrar_wakaf'),
                    'proposal_program'=> storeasfile($request->file('proposal_program'), 'berkas_lembaga/lembaga_'.$organization->id.'/program_wakaf/program_wakaf_'.$program->id, time().'_'.'proposal_program'),
                ]);
            }

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

    public function approved($id)
    {
        try {
            $program = Program::with('organization')
                ->where('id', $id)->first();
            $program->update(['status' => 'approved']);
            $program->organization->user->notify(new ApproveProgram($program));
            $data = [
                'success' => true,
                'message' => 'Lembaga berhasil disetujui',
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => 'Lembaga gagal disetujui! err'.$e->getMessage()
            ];
            return response()->json($data);
        }

    }
    public function reject($id)
    {
        try {
            $program = Program::with('organization')
                ->where('id', $id)->first();
            $program->update(['status' => 'rejected']);
            $program->organization->user->notify(new RejectProgram($program));
            $data = [
                'success' => true,
                'message' => 'Lembaga berhasil disetujui',
            ];
            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'success' => false,
                'message' => 'Lembaga gagal disetujui! err'.$e->getMessage()
            ];
            return response()->json($data);
        }

    }


}
