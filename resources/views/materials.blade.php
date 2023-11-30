@extends('layout.admin')
@section('title', 'Bahan Baku')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="/materials" method="post">
      @csrf
      <div class="row">
        <h2>Tambah Bahan Baku</h2>
        <div class="input-group">
          <input type="text" placeholder="Nama" name="nama" />
        </div>
        <div class="input-group">
          <input type="text" placeholder="Harga" name="harga" />
        </div>
      </div>
      <a href="#" class="btn">Close</a>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </div>
</div>
<table id="materials">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Harga</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($materials as $item)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->nama }}</td>
      <td>{{ $item->harga }}</td>
      <td>
        <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}" class="btn">Hapus</a>
      </td>
    </tr>
    {{-- MODAL EDIT --}}
    <div class="popup" id="edit{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Ubah Bahan Baku</h2>
          <form action="materials/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group">
                <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}"/>
            </div>
            <div class="input-group">
                <input type="text" placeholder="Harga" name="harga" value="{{ $item->harga }}"/>
            </div>
            <a href="#" class="btn">Close</a>
            <button type="submit" class="btn">Ubah</button>
          </form>
        </div>
      </div>
    </div>
    {{-- MODAL DELETE --}}
    <div class="popup" id="delete{{ $item->id }}">
      <div class="popup__content">
        <form action="materials/{{ $item->id }}" method="POST">
          @csrf
          @method('DELETE')
          <p class="popup__text">
            Yakin ingin hapus bahan baku {{ $item->nama }}?
          </p>
          <a href="#" class="btn">Close</a>
          <button type="submit" class="btn">Hapus</button>
        </form>
      </div>
    </div>
    @endforeach
  </tbody>
</table>
@endsection