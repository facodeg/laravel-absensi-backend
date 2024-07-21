@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body p-3">
                    <h5 class="mb-3">Daftar Pegawai</h5>
                    <a href="{{ route('pegawais.create') }}" class="btn btn-primary mb-3">Tambah Pegawai</a>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telepon</th>
                                    <th>Alamat</th>
                                    <th>Jabatan</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Pendidikan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pegawais as $pegawai)
                                    <tr>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->user->name }}</td>
                                        <td>{{ $pegawai->user->email }}</td>
                                        <td>{{ $pegawai->user->phone}}</td>
                                        <td>{{ $pegawai->alamat }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->tanggal_lahir }}</td>
                                        <td>{{ $pegawai->pendidikan }}</td>
                                        <td>
                                            <a href="{{ route('pegawais.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('pegawais.destroy', $pegawai->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
