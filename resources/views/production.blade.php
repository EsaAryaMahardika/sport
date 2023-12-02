@extends('layout.admin')
@section('title', 'Produksi')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="/production" method="post">
      @csrf
      <div class="row">
        <h2>Tambah Produksi</h2>
        <div class="input-group">
          <select name="product_id">
              <option value="">Pilih Produk</option>
              @foreach ($product as $data)
                  <option value="{{ $data->id }}" data-price="{{ $data->harga }}">{{ $data->nama }}</option>
              @endforeach
          </select>
        </div>
        <div class="input-group">
          <input type="number" placeholder="Jumlah" name="jumlah" />
        </div>
        <div class="input-group">
          <input type="hidden" name="status" value="todo"/>
        </div>
        <div class="input-group">
          <label for="">Mulai Produksi</label>
          <input type="date" name="mulai" />
        </div>
      </div>
      <a href="#" class="btn">Close</a>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </div>
</div>
<table id="production">
  <thead>
    <tr>
      <th>Referensi</th>
      <th>Produk</th>
      <th>Jumlah</th>
      <th>Mulai</th>
      <th>Selesai</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($production as $item)
    <tr>
      <td>{{ $item->referensi }}</td>
      <td>{{ $item->product['nama'] }}</td>
      <td>{{ $item->jumlah }}</td>
      <td>{{ date('d-m-Y', strtotime($item->mulai)) }}</td>
      <td>
        @if ($item->selesai)
          {{ date('d-m-Y', strtotime($item->selesai)) }}
        @endif
      </td>
      <td>
        @if ($item->status == 'todo')
          <a href="#ca{{ $item->id }}" class="btn">Cek Stok</a>
        @elseif($item->status == 'start')
          <a href="#mad{{ $item->id }}" class="btn">Selesai</a>
        @elseif($item->status == 'finish')
          <a href="reportPC/{{ $item->id }}" class="btn" target="_blank">Laporan</a>
        @endif
      </td>
    </tr>
    {{-- MODAL CHECK AVAILABILITY --}}
    <div class="popup" id="ca{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Cek Stok</h2>
          <div class="input-group">
            <div class="col-third">Bahan Baku</div>
            <div class="col-third">Kebutuhan</div>
            <div class="col-third">Stok</div>
          </div>
          @php
            $canProduce = false;
          @endphp
          <div class="input-group">
            @foreach ($item->materials as $data)
              <div class="col-third">
                {{ $data->nama }}
              </div>
              <div class="col-third">
                {{ $data->pivot->jumlah * $item->jumlah }}
              </div>
              <div class="col-third">
                {{ $data->stok }}
              </div>
              @if ($data->pivot->jumlah < $data->stok)
                @php
                  $canProduce = true
                @endphp
              @endif
            @endforeach
          </div>
          @if ($canProduce)
            <div class="center">
              <h3>Stok tersedia</h3>
            </div>
            <form action="start/{{ $item->id }}" method="POST">
              @csrf
              @method('PUT')
              <button type="submit" class="btn">Mulai Produksi</button>
            </form>
          @else
          <div class="center">
            <h3>Stok bahan baku kurang, tidak bisa produksi</h3>
          </div>
          @endif
          <a href="#" class="btn">Close</a>
        </div>
      </div>
    </div>
    {{-- MODAL MARK AS DONE --}}
    <div class="popup" id="mad{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <form action="mad/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <h2 class="center">Apakah produksi selesai?</h2>
            @foreach ($item->materials as $data)
              @php
                $stokM = $data->stok - $data->pivot->jumlah * $item->jumlah
              @endphp
              <input type="hidden" name="stokM[]" value="{{ $stokM }}">
              <input type="hidden" name="materials_id[]" value="{{ $data->id }}">
            @endforeach
            @php
                $stokP = $item->jumlah + $item->product['stok']
            @endphp
            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
            <input type="hidden" name="stokP" value="{{ $stokP }}">
            <a href="#" class="btn">Belum</a>
            <button type="submit" class="btn">Sudah</button>
          </form>
        </div>
      </div>
    </div>
    @endforeach
  </tbody>
</table>
@endsection