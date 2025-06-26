@extends('layouts.app')

@section('title', 'Data Firebase')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Data Pengaduan dari Firebase</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Judul</th>
                <th>Status</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengaduans as $p)
            <tr>
                <td>{{ $p['nama'] ?? '-' }}</td>
                <td>{{ $p['judul'] ?? '-' }}</td>
                <td>{{ $p['status'] ?? '-' }}</td>
                <td>{{ $p['created_at'] ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
