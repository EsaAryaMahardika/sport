@extends('layout.admin')
@section('title', 'Kategori')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="/category" method="post">
      @csrf
      <div class="row">
        <h2>Tambah Kategori</h2>
        <div class="input-group">
          <input type="text" placeholder="Nama" name="nama" />
        </div>
      </div>
      <a href="#" class="btn">Close</a>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </div>
</div>
<table id="category">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($category as $item)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->nama }}</td>
      <td>
        <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}" class="btn">Hapus</a>
      </td>
    </tr>
    {{-- MODAL EDIT --}}
    <div class="popup" id="edit{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Teknisi</h2>
          <form action="/category/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="input-group">
                <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}" />
              </div>
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
        <form action="category/{{ $item->id }}" method="POST">
          @csrf
          @method('DELETE')
          <p class="popup__text">
            Yakin ingin hapus kategori {{ $item->nama }}?
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