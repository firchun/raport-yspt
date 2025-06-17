<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pengasuh;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'title' => 'Users',
            'users' => User::all()
        ];
        return view('admin.users.index', $data);
    }
    public function createFromPengasuh(Request $request)
    {
        $pengasuh = Pengasuh::findOrFail($request->id);

        $namaSlug = Str::slug($pengasuh->nama, '_');
        $email = $namaSlug . '@yspt.com';

        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            return response()->json([
                'message' => 'Akun sudah ada.',
                'user' => [
                    'id' => $existingUser->id,
                    'name' => $existingUser->name,
                    'email' => $existingUser->email
                ]
            ], 400);
        }

        $user = User::create([
            'name' => $pengasuh->nama,
            'email' => $email,
            'password' => Hash::make('password'),
            'role' => 'User',
        ]);

        return response()->json([
            'message' => 'Akun berhasil dibuat untuk ' . $pengasuh->nama
        ]);
    }
    public function resetPassword(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->password = Hash::make('password');
        $user->save();

        return response()->json([
            'message' => 'Password berhasil di-reset ke "password".'
        ]);
    }
    public function getUsersDataTable()
    {
        $users = User::select(['id', 'name', 'email', 'created_at', 'updated_at', 'role', 'avatar'])->orderByDesc('id');

        return Datatables::of($users)
            ->addColumn('avatar', function ($user) {
                return view('admin.users.components.avatar', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.components.actions', compact('user'));
            })
            ->addColumn('role', function ($user) {
                return '<span class="badge bg-label-primary">' . $user->role . '</span>';
            })

            ->rawColumns(['action', 'role', 'avatar'])
            ->make(true);
    }
    public function store(Request $request)
    {
        if ($request->filled('id')) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
            ]);
        } else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }


        if ($request->filled('id')) {
            $usersData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
            ];
            $user = User::find($request->input('id'));
            if (!$user) {
                return response()->json(['message' => 'user not found'], 404);
            }

            $user->update($usersData);
            $message = 'user updated successfully';
        } else {
            $usersData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role' => $request->input('role'),
                'password' => Hash::make('password'),
            ];

            User::create($usersData);
            $message = 'user created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function edit($id)
    {
        $User = User::find($id);

        if (!$User) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($User);
    }
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}