@extends('layouts.app')

@section('content')
<div class="container mx-auto my-6">
    <h1 class="text-2xl font-semibold mb-4 text-white">Gestion des utilisateurs</h1>
    <table class="table-auto w-full border-collapse bg-gray-800 rounded-lg shadow-md">
        <thead>
            <tr class="border-b bg-gray-700 text-white">
                <th class="px-6 py-4 text-left">Nom</th>
                <th class="px-6 py-4 text-left">Email</th>
                <th class="px-6 py-4 text-left">Rôle</th>
                <th class="px-6 py-4 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="text-white">
            @foreach ($users as $user)
                <tr class="border-b bg-gray-800">
                    <!-- Nom -->
                    <td class="px-6 py-4 text-center align-middle">{{ $user->last_name }}</td>
                    
                    <!-- Email -->
                    <td class="px-6 py-4 text-center align-middle">{{ $user->email }}</td>
                    
                    <!-- Rôle -->
                    <td class="px-6 py-4 text-center align-middle">{{ ucfirst($user->role) }}</td>
                    
                    <!-- Actions -->
                    <td class="px-6 py-4 text-center align-middle">
                        <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="role" class="border px-2 py-1 rounded bg-gray-500 text-white">
                                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }} class="text-black">Membre</option>
                                <option value="project_manager" {{ $user->role === 'project_manager' ? 'selected' : '' }} class="text-black">Chef de projet</option>
                                <option value="team_member" {{ $user->role === 'team_member' ? 'selected' : '' }} class="text-black">Membre d'équipe</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }} class="text-black">Administrateur</option>
                            </select>
                            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-1 rounded hover:bg-blue-600 transition duration-300">Modifier</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
