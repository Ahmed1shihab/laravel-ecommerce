<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('user.update') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div>
                            <p>Name</p>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="block w-72  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md ">
                        </div>

                        <div class="mt-4">
                            <p>Email</p>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="block w-72  shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md ">
                        </div>

                        <div class="mt-4">
                            <p>Password</p>
                            <input type="password" name="password" class="block w-72 shadow border-l-2 border-r-0 border-t-0 border-b-0 border-dblue focus:ring-0 focus:shadow-md ">
                            <span class="text-xs">Keep it empty if you won't to change password</span>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-dblue text-white p-2 rounded transition-all duration-300 hover:bg-opacity-90">Update Profile 👽</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
