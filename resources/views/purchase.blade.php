@extends('layout.admin')
@section('title', 'Penjualan')
@section('content')
<div class="some-text">
    <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
    <div class="popup__content">
        <form action="/purchase" method="post">
            @csrf
            <div class="row">
                <h2>Pembelian</h2>
                <div class="input-group">
                    <select name="customer_id">
                        <option value="">Pilih Vendor</option>
                    </select>
                </div>
                <div id="inputMaterials">
                    <div>
                        <div class="col-third">
                            <label>Bahan Baku</label>
                        </div>
                        <div class="col-third">
                            <label>Jumlah</label>
                        </div>
                        <div class="col-third">
                            <label>Harga</label>
                        </div>
                    </div>
                    <div id="template" class="input-group">
                        <div class="col-third">
                            <select name="materials_id[]">
                                <option value="">Pilih Produk</option>
                                {{-- @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" data-harga="{{ $material->harga }}">{{ $material->nama }}</option>
                                @endforeach --}}
                            </select>
                        </div>
                        <div class="col-third">
                            <input type="number" name="jumlah[]">
                        </div>
                        <div class="col-third">
                            <input type="text" class="harga-label" disabled>
                        </div>
                    </div>
                </div>
                <div class="center">
                    <button type="button" class="btn" id="addMaterialInput">+</button>
                </div>
            </div>
            <a href="#" class="btn">Close</a>
            <button type="submit" class="btn">Tambah</button>
        </form>
    </div>
</div>
<table id="factory">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kabupaten/Kota</th>
            <th>Provinsi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach ($factory as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->alamat }}</td>
            <td>{{ $item->kab['nama'] }}</td>
            <td>{{ $item->prov['nama'] }}</td>
            <td>
                <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}"
                    class="btn">Hapus</a>
            </td>
        </tr> --}}
        {{-- MODAL EDIT --}}
        {{-- <div class="popup" id="edit{{ $item->id }}">
            <div class="popup__content">
                <div class="row">
                    <h2>Ubah Pabrik</h2>
                    <form action="factory/{{ $item->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}" />
                        </div>
                        <div class="input-group">
                            <input type="text" placeholder="Alaamt" name="alamat" value="{{ $item->alamat }}" />
                        </div>
                        <div class="input-group">
                            <select name="prov_id" class="prov">
                                <option value="{{ $item->prov_id }}">{{ $item->prov['nama'] }}</option>
                                @foreach ($prov as $data)
                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <select name="kab_id" class="kab">
                                <option value="{{ $item->kab_id }}">{{ $item->kab['nama'] }}</option>
                            </select>
                        </div>
                        <a href="#" class="btn">Close</a>
                        <button type="submit" class="btn">Ubah</button>
                    </form>
                </div>
            </div>
        </div> --}}
        {{-- MODAL DELETE --}}
        {{-- <div class="popup" id="delete{{ $item->id }}">
            <div class="popup__content">
                <form action="factory/{{ $item->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="popup__text">
                        Yakin ingin hapus Pabrik {{ $item->nama }}?
                    </p>
                    <a href="#" class="btn">Close</a>
                    <button type="submit" class="btn">Hapus</button>
                </form>
            </div>
        </div> --}}
        {{-- @endforeach --}}
    </tbody>
</table>
@endsection