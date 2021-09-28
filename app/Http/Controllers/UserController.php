<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'password' => ['sometimes', 'string', 'nullable', 'min:8']
        ]);

        $user = auth()->user();
        $inputs = $request->except('password');

        if (! $request->filled('password')) {
            $user->fill($inputs)->save();

            return back()->with('success_message', 'Profile Updated Successfuly 😀');
        }

        $user->password = bcrypt($request->password);
        $user->fill($inputs)->save();

        return back()->with('success_message', 'Profile and password Updated Successfuly 😀');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->destroy();

        return redirect()->route('landing-page')->with('success_message', 'Profile Deleted Successfully');
    }
}
