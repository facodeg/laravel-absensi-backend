<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //index

        $izin = Izin::with('user')->orderBy('user_id')->get();
        return view('pages.izin.index', compact('izin'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    //show
    public function show(string $id)
    {
        $izin = Izin::with('user')->findOrFail($id);
        return view('pages.izin.show', compact('izin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    //edit
    public function edit(string $id)
    {
        $izin = Izin::findOrFail($id);
        return view('pages.izin.edit', compact('izin'));
    }

    /**
     * Update the specified resource in storage.
     */
    //update
    public function update(Request $request, string $id)
    {
        $izin = Izin::findOrFail($id);
        $izin->is_approved = $request->is_approved;
        $izin->save();
        return redirect()->route('izins.index')->with('success', 'Data izin berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
