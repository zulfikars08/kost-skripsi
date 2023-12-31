<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        // Retrieve the list of users
        $users = User::all();

        $query = User::query();
     
        // Cek apakah ada kata kunci pencarian yang diberikan
        if ($request->filled('katakunci')) {
            $katakunci = $request->input('katakunci');
            $query->where('name', 'like', '%' . $katakunci . '%');
        }
    
        // Paginate hasil query
        $users = $query->paginate(5);
    
        // Cek apakah request adalah AJAX request
        if ($request->ajax()) {
            // Jika iya, kembalikan partial view yang berisi tabel penyewa saja
            return view('manage-users.list', compact('users'))->render(); // Gunakan render() untuk mendapatkan HTML
        }

        return view('manage-users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
    
            // Validate the request data
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email', // Ensure email is unique in the 'users' table
                'password' => 'required|min:6',
                'role' => 'required|in:user,admin',
            ]);
    
            // Create a new user instance
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->role = $request->input('role');
            // Add other fields as needed
    
            // Save the user
            $user->save();
    
            // Commit the database transaction
            DB::commit();
    
            // Redirect with success message
            return redirect()->to('manage-users')->with('success_add', 'Berhasil menambahkan data user');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an exception
            DB::rollBack();
    
            // Log or handle the exception as needed
            return redirect()->back()->with('error', 'Gagal menambahkan data user ');
        }
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
        $user = User::find($id);

         if (!$user) {
        // Handle the case where the user is not found, for example, by redirecting to a 404 page.
        return redirect()->route('error.404'); // Replace 'error.404' with your error route.
    }

        return view('manage-users.edit', compact('user'));
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
            // Begin a database transaction
            DB::beginTransaction();
    
            // Find the user by ID
            $user = User::find($id);
    
            // Validate the request data
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required|in:user,admin', // You can define your role values here
            ]);
    
            // Update the user data
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
            ]);
    
            // Commit the database transaction
            DB::commit();
    
            // Redirect with success message
            return redirect()->route('manage-users.index')
                ->with('success_update', 'Update user berhasil');
        } catch (\Exception $e) {
            // Rollback the database transaction in case of an exception
            DB::rollBack();
    
            // Log or handle the exception as needed
            return redirect()->back()->with('error', 'Gagal mengupdate user');
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
