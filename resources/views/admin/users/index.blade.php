@extends('admin.layouts.app')
@section('title', 'Kelola Pengguna')
@section('page-title', 'Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-headline font-extrabold text-primary">Pengguna</h1>
            <p class="text-sm text-on-surface-variant mt-1">Kelola akun pengguna sistem SSB</p>
        </div>
        <a href="{{ route('superadmin.users.create') }}" class="btn-premium">
            <i class="fas fa-plus mr-1.5"></i> Tambah Pengguna
        </a>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $i => $user)
                    <tr>
                        <td class="text-on-surface-variant font-medium">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary text-on-primary text-xs font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="font-bold text-on-surface">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="text-on-surface-variant">{{ $user->email }}</td>
                        <td class="text-center">
                            <span class="badge-premium {{ $user->role === 'superadmin' ? '' : 'secondary' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('superadmin.users.edit', $user) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 bg-tertiary-container text-tertiary text-xs font-bold rounded-xl hover:shadow-sm transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if (auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('superadmin.users.destroy', $user) }}" onsubmit="event.preventDefault(); confirmDelete(this)">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-8 h-8 bg-error-container text-error text-xs font-bold rounded-xl hover:shadow-sm transition"
                                        title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-on-surface-variant py-16">
                            <i class="fas fa-users text-4xl mb-3 block text-on-surface-variant/40"></i>
                            <p>Belum ada pengguna</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
        <div class="px-6 py-4 border-t border-outline-variant/10 bg-surface-container-low/20">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
