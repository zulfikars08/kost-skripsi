<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table table-striped" style="width: 100%;">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Email</th>
            <th>Peran</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}"><i class="fas fa-edit" style="color: white"></i></button>
                @include('manage-users.edit')
                {{-- <form action="{{ route('manage-users.destroy', $user->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                </form> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>