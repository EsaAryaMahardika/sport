@extends('layout.admin')
@section('title', 'Produk')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="product" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <h2>Tambah Produk</h2>
          <div class="input-group">
            <input type="text" placeholder="Nama" name="nama" />
          </div>
          <div class="input-group">
            <select name="category_id">
                <option value="">Pilih Kategori</option>
                @foreach ($category as $data)
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
            </select>
          </div>
          <div class="input-group">
            <input type="text" placeholder="Harga" name="harga" />
          </div>
          <div class="input-group">
            <select name="factory_id">
                <option value="">Pilih Pabrik</option>
                @foreach ($factory as $data)
                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                @endforeach
            </select>
          </div>
          <div class="input-group">
            <label for="foto">Foto</label>
            <input type="file" name="foto"/>
          </div>
        </div>
        <a href="#" class="btn">Close</a>
        <button type="submit" class="btn">Ubah</button>
      </form>
  </div>
</div>
<table id="product">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Stok</th>
      <th>Pabrik</th>
      <th>Foto</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($product as $item)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->nama }}</td>
      <td>{{ $item->category['nama'] }}</td>
      <td>{{ $item->harga }}</td>
      <td>{{ $item->stok }}</td>
      <td>{{ $item->factory['nama'] }}</td>
      <td><img src="{{ asset('img/' . $item->foto) }}"></td>
      <td>
        <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}" class="btn">Hapus</a>
      </td>
    </tr>
    {{-- MODAL EDIT --}}
    <div class="popup" id="edit{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Ubah Produk</h2>
          <form action="product/{{ $item->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="input-group">
                <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}" />
              </div>
              <div class="input-group">
                <select name="category_id">
                  <option value="{{ $item->category_id }}">{{ $item->category['nama'] }}</option>
                  @foreach ($category as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-group">
                <input type="text" placeholder="Harga" name="harga" value="{{ $item->harga }}" />
              </div>
              <div class="input-group">
                <select name="factory_id">
                  <option value="{{ $item->factory_id }}">{{ $item->factory['nama'] }}</option>
                  @foreach ($factory as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                  @endforeach
                </select>
              </div>
              <img src="{{ asset('img/' . $item->foto) }}">
              <div class="input-group">
                <label for="foto">Foto</label>
                <input type="file" name="foto" />
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
        <form action="product/{{ $item->id }}" method="POST">
          @csrf
          @method('DELETE')
          <p class="popup__text">
            Yakin ingin hapus produk {{ $item->nama }}?
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