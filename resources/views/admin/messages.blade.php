@extends('layouts.app')

@section('content')
<section class="about_section layout_padding" style="background-color: #f4f7f6; min-height: 80vh;">
    <div class="container">
        <div class="heading_container mb-4">
            <h2 style="color: #0a2458; font-weight: 800;">Gelen Mesajlar</h2>
            <p class="text-muted">Mesajların detayını görmek için üzerine tıklayabilirsiniz.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm mb-3">{{ session('success') }}</div>
        @endif

        <div class="table-responsive shadow-sm" style="border-radius: 15px; overflow: hidden;">
            <table class="table table-hover bg-white mb-0">
                <thead style="background-color: #0a2458; color: #fdd31d;">
                    <tr>
                        <th class="py-3 px-4">Tarih</th>
                        <th class="py-3">Gönderen</th>
                        <th class="py-3">Mesaj Özeti</th>
                        <th class="py-3 text-center">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr style="cursor: pointer;">
                        {{-- Mesaja tıklandığında Modal'ı açar --}}
                        <td class="align-middle px-4" data-toggle="modal" data-target="#msgModal{{ $msg->id }}">
                            {{ $msg->created_at->format('d.m.Y H:i') }}
                        </td>
                        <td class="align-middle font-weight-bold" data-toggle="modal" data-target="#msgModal{{ $msg->id }}">
                            {{ $msg->name }}
                        </td>
                        <td class="align-middle text-muted" data-toggle="modal" data-target="#msgModal{{ $msg->id }}">
                            {{ Str::limit($msg->message, 50) }}
                        </td>
                        <td class="align-middle text-center">
                            <form action="{{ route('admin.messages.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Bu mesajı silmek istediğinize emin misiniz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius: 20px;">
                                    <i class="fa-solid fa-trash"></i> Sil
                                </button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="msgModal{{ $msg->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
                                <div class="modal-header" style="background-color: #0a2458; color: #fdd31d;">
                                    <h5 class="modal-title font-weight-bold">Mesaj Detayı</h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="text-muted small d-block mb-0">Gönderen:</label>
                                        <span class="font-weight-bold" style="color: #0a2458; font-size: 1.1rem;">{{ $msg->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="text-muted small d-block mb-0">E-Posta:</label>
                                        <a href="mailto:{{ $msg->email }}" class="text-info">{{ $msg->email }}</a>
                                    </div>
                                    <hr>
                                    <div>
                                        <label class="text-muted small d-block mb-1">Mesaj:</label>
                                        <p style="white-space: pre-wrap; color: #444; line-height: 1.6;">{{ $msg->message }}</p>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light">
                                    <small class="text-muted mr-auto">{{ $msg->created_at->format('d.m.Y H:i') }} tarihinde gönderildi.</small>
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius: 20px;">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">Henüz mesaj yok.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection