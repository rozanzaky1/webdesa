@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Penduduk</h1>
        <a href="{{ route('residents.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <table class="table table-responsive table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Agama</th>
                                <th>Status Perkawinan</th>
                                <th>Pekerjaan</th>
                                <th>Telepon</th>
                                <th>Status Penduduk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($residents as $item)
                                <tr>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->gender }}</td>
                                    <td>{{ $item->birth_place }}, {{ $item->birth_date }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->religion }}</td>
                                    <td>{{ $item->marital_status }}</td>
                                    <td>{{ $item->occupation }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center" style="gap: 10px;">
                                            <!-- Tombol Edit -->
                                            <a href="{{ route('residents.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <!-- Tombol Hapus (Trigger Modal) -->
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#confirmationDelete{{ $item->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal Konfirmasi Hapus Component -->
                                        @include('components.confirmation-delete', [
                                            'id' => $item->id,
                                            'name' => $item->name,
                                            'nik' => $item->nik,
                                            'route' => route('residents.destroy', $item->id)
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center py-3">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
