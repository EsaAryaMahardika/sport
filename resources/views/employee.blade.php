@extends('layout.admin')
@section('title', 'Employee')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="/employee" method="post">
      @csrf
      <div class="row">
        <h2>Pegawai</h2>
        <div class="input-group">
          <input type="text" placeholder="Nama" name="nama" />
        </div>
        <div class="input-group">
          <input type="text" placeholder="Alamat" name="alamat" />
        </div>
        <div class="input-group">
          <input type="email" placeholder="Email" name="email" />
        </div>
        <div class="input-group">
          <input type="text" placeholder="Nomor Telepon" name="telp" />
        </div>
        <div class="input-group">
          <select class="depart" name="depart_id">
            <option value="">Pilih Departemen</option>
            @foreach ($depart as $item)
              <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
          </select>
        </div>
        <div class="input-group">
          <select class="jobpos" name="jobpos_id">
            <option value="">Pilih Posisi Kerja</option>
            @foreach ($jobpos as $item)
                <option value="{{ $item->id }}">{{ $item->nama }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <a href="#" class="btn">Close</a>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </div>
</div>
<table id="employee">
  <thead>
    <tr>
      <th>Nama</th>
      <th>Alamat</th>
      <th>Email</th>
      <th>No.Telepon</th>
      <th>Departemen</th>
      <th>Posisi Kerja</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($employee as $item)
    <tr>
      <td>{{ $item->nama }}</td>
      <td>{{ $item->alamat }}</td>
      <td>{{ $item->email }}</td>
      <td>{{ $item->telp }}</td>
      <td>{{ $item->depart['nama'] }}</td>
      <td>{{ $item->jobpos['nama'] }}</td>
      <td>
        <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}" class="btn">Hapus</a> | <a href="idcard/{{ $item->id }}" class="btn">ID Card</a>
      </td>
    </tr>
    {{-- MODAL EDIT --}}
    <div class="popup" id="edit{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Pegawai</h2>
          <form action="/employee/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="input-group">
                <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}" />
              </div>
              <div class="input-group">
                <input type="text" placeholder="Alamat" name="alamat" value="{{ $item->alamat }}" />
              </div>
              <div class="input-group">
                <input type="email" placeholder="E-mail" name="email" value="{{ $item->email }}" />
              </div>
              <div class="input-group">
                <input type="text" placeholder="Nomor Telepon" name="telp" value="{{ $item->telp }}" />
              </div>
              <div class="input-group">
                <select name="depart_id" class="depart">
                  <option value="{{ $item->depart_id }}">{{ $item->depart['nama'] }}</option>
                  @foreach ($depart as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                  @endforeach
                </select>
              </div>
              <div class="input-group">
                <select name="jobpos_id" class="jobpos">
                  <option value="{{ $item->jobpos_id }}">{{ $item->jobpos['nama'] }}</option>
                  @foreach ($jobpos as $data)
                  <option value="{{ $data->id }}">{{ $data->nama }}</option>
                  @endforeach
                </select>
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
        <form action="employee/{{ $item->id }}" method="POST">
          @csrf
          @method('DELETE')
          <p class="popup__text">
            Yakin ingin hapus Pegawai {{ $item->nama }}?
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