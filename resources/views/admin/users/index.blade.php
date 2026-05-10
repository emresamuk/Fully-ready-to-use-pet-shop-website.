@extends('layouts.app')

@section('content')
<div class="container py-5" style="min-height: 80vh;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 style="color: #0a2458; font-weight: 800;"><i class="fa-solid fa-users mr-2"></i> Kullanıcı Yönetimi</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm" style="border-radius: 10px;">
            <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover mb-0 text-center align-middle">
                <thead style="background-color: #0a2458; color: white;">
                    <tr>
                        <th>ID</th>
                        <th>Ad Soyad</th>
                        <th>E-Posta</th>
                        <th>Bakiye</th>
                        <th>Kayıt Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr style="{{ $user->is_frozen ? 'background-color: #f8d7da; opacity: 0.9;' : '' }}">
                            <td class="font-weight-bold">{{ $user->id }}</td>
                            <td class="font-weight-bold" style="color: #0a2458;">
                                <i class="fa-solid fa-user-circle mr-1 text-muted"></i> {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td style="color: #27ae60; font-weight: bold;">${{ number_format($user->balance, 2) }}</td>
                            <td>{{ $user->created_at->format('d.m.Y') }}</td>
                            <td>
                                @if($user->is_frozen)
                                    <span class="badge badge-danger px-3 py-2" style="border-radius: 20px;"><i class="fa-solid fa-snowflake mr-1"></i> Donduruldu</span>
                                @else
                                    <span class="badge badge-success px-3 py-2" style="border-radius: 20px;"><i class="fa-solid fa-check mr-1"></i> Aktif</span>
                                @endif
                            </td>
                            <td>
                                {{-- Hesabı Dondur / Aç Butonu --}}
                                <a href="{{ route('admin.users.toggle-freeze', $user->id) }}" class="btn btn-sm btn-{{ $user->is_frozen ? 'success' : 'warning' }} mr-1" title="{{ $user->is_frozen ? 'Hesabı Aktifleştir' : 'Hesabı Dondur' }}">
                                    <i class="fa-solid fa-{{ $user->is_frozen ? 'unlock' : 'lock' }}"></i>
                                </a>

                                {{-- Kullanıcıyı Sil Butonu --}}
                                <a href="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('DİKKAT: Bu kullanıcıyı tamamen silmek istediğinize emin misiniz? Bu işlem geri alınamaz!')" title="Kullanıcıyı Sil">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-muted">Sistemde henüz kayıtlı bir müşteri bulunmuyor.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection