@extends('layouts.app')

@section('content')

<div class="container-fluid" data-aos="fade-in">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #b0ecff">
            <li class="breadcrumb-item"><i class="bi-house-door-fill"></i>&nbsp;<a href="{{ route('home') }}"> Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
        </ol>
    </nav>

    <div class="card border-top border-3 border-success p-4">
        <div class="row">
            <div class="col-md-6 mb-2">
                <div class="row gx-2">
                    <div class="col-md-2">
                        <select id="pagelength" class="form-select" readonly>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-10">
                        <input id="searching" type="text" class="form-control" placeholder="Pencarian ...">
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-2">
                <button type="button" class="btn btn-primary float-right" data-bs-toggle="modal" data-bs-target="#modalUser">
                    Tambah User
                </button>
            </div>
        </div>

        <table id="data_tables" class="table table-striped" width="100%">
            <thead class="bg-app-table">
                <tr>
                    <th width="20">No.</th>
                    <th width="100">Nama Profil</th>
                    <th width="50">Username</th>
                    <th width="50">Level</th>
                    <th width="50">Pilihan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ strtoupper($data->name) }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->level == 1 ? 'Administrator' : 'User' }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editRow('{{ $data->id }}')">
                                <i class="bi-pencil"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRow('{{ $data->id }}')">
                                <i class="bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
	</div>
</div>

@endsection

@section('footer-script')
    @include('scripts.users')
@endsection