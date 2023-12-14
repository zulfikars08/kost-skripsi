<?php

namespace App\Http\Controllers;

use App\Models\TipeKamar;
use Illuminate\Http\Request;

class TipeKamarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = TipeKamar::query();
     
        // Cek apakah ada kata kunci pencarian yang diberikan
        if ($request->filled('katakunci')) {
            $katakunci = $request->input('katakunci');
            $query->where('tipe_kamar', 'like', '%' . $katakunci . '%');
        }
    
        // Paginate hasil query
        $tipeKamar= $query
        ->orderBy('created_at', 'desc')
        ->paginate(5);
    
        // Cek apakah request adalah AJAX request
        if ($request->ajax()) {
            // Jika iya, kembalikan partial view yang berisi tabel penyewa saja
            return view('tipe_kamar.list', compact('tipeKamar'))->render(); // Gunakan render() untuk mendapatkan HTML
        }
    

       return view('tipe_kamar.index', compact('tipeKamar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('tipe_kamar.create');
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
            'tipe_kamar' => 'required|max:255',
            // Add any other validation rules for your fields
        ]);

        // Create a new Fasilitas instance
        $tipeKamar = new TipeKamar();
        $tipeKamar->tipe_kamar = $request->input('tipe_kamar');
        // Add any other fields you want to fill

        // Save the Fasilitas record
        $tipeKamar->save();

        // Redirect back to the index page with a success message
        return redirect()->route('tipe_kamar.index')->with('success_add', 'Tipe Kamar created successfully.');
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
        $tipeKamar = TipeKamar::findOrFail($id);

        // Pass the Fasilitas record to the edit view
        return view('tipe_kamar.edit', compact('tipeKamar'));
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
            'tipe_kamar' => 'required|max:255',
            // Add any other validation rules for your fields
        ]);

        // Find the Fasilitas record by ID
        $tipeKamar = TipeKamar::findOrFail($id);

        // Update the Fasilitas record
        $tipeKamar->tipe_kamar = $request->input('tipe_kamar');
        // Add any other fields you want to update

        // Save the updated Fasilitas record
        $tipeKamar->save();

        // Redirect back to the index page with a success message
        return redirect()->route('tipe_kamar.index')->with('success_update', 'Tipe Kamar updated successfully.');
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
        $tipeKamar = TipeKamar::findOrFail($id);

        // Delete the Fasilitas record
        $tipeKamar->delete();

        // Redirect back to the index page with a success message
        return redirect()->route('tipe_kamar.index')->with('success_delete', 'Tipe Kamar deleted successfully.');
    }
}
