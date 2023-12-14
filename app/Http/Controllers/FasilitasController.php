<?php

namespace App\Http\Controllers;

use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Fasilitas::query();
     
         // Cek apakah ada kata kunci pencarian yang diberikan
         if ($request->filled('katakunci')) {
             $katakunci = $request->input('katakunci');
             $query->where('nama_fasilitas', 'like', '%' . $katakunci . '%');
         }
     
         // Paginate hasil query
         $fasilitas = $query
         ->orderBy('created_at', 'desc')
         ->paginate(5);
     
         // Cek apakah request adalah AJAX request
         if ($request->ajax()) {
             // Jika iya, kembalikan partial view yang berisi tabel penyewa saja
             return view('fasilitas.list', compact('fasilitas'))->render(); // Gunakan render() untuk mendapatkan HTML
         }
     

        return view('fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'nama_fasilitas' => 'required|max:255',
            // Add any other validation rules for your fields
        ]);

        // Create a new Fasilitas instance
        $fasilitas = new Fasilitas();
        $fasilitas->nama_fasilitas = $request->input('nama_fasilitas');
        // Add any other fields you want to fill

        // Save the Fasilitas record
        $fasilitas->save();

        // Redirect back to the index page with a success message
        return redirect()->route('fasilitas.index')->with('success_add', 'Fasilitas created successfully.');
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
        $fasilitas = Fasilitas::findOrFail($id);

        // Pass the Fasilitas record to the edit view
        return view('fasilitas.edit', compact('fasilitas'));
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
        $request->validate([
            'nama_fasilitas' => 'required|max:255',
            // Add any other validation rules for your fields
        ]);

        // Find the Fasilitas record by ID
        $fasilitas = Fasilitas::findOrFail($id);

        // Update the Fasilitas record
        $fasilitas->nama_fasilitas = $request->input('nama_fasilitas');
        // Add any other fields you want to update

        // Save the updated Fasilitas record
        $fasilitas->save();

        // Redirect back to the index page with a success message
        return redirect()->route('fasilitas.index')->with('success_update', 'Fasilitas updated successfully.');
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
        $fasilitas = Fasilitas::findOrFail($id);

        // Delete the Fasilitas record
        $fasilitas->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('fasilitas.index')->with('success_delete', 'Fasilitas deleted successfully.');
    }
}
