<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotel = $request->session()->get('hotel_id');
        $users = User::paginate(10);
        return view('auth.users.index', compact('users', 'hotel'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hotel = $request->session()->get('hotel_id');
        return view('auth.users.form', compact('hotel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $params = $request->all();
        User::create($params);
        session()->flash('success', 'Пользователь ' . $request->name . ' добавлен');
        return redirect()->route('users.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        $hotel = $request->session()->get('hotel_id');
        return view('auth.users.form', compact('user', 'hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $params = $request->all();
        $user->update($params);
        session()->flash('success', 'Пользователь ' . $user->name . ' обновлен');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', 'Пользователь ' . $user->title . ' удален');
        return redirect()->route('users.index');
    }
}
