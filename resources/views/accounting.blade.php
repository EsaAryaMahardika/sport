@extends('layout.admin')
@section('title', 'Akuntansi')
@section('content')
<div class="row">
  <div class="some-text">
    <a class="btn btn-input" href="acc-purchase/">Cetak Laporan</a>
  </div>
  <table id="purchase">
    <thead>
      <tr>
        <th>Invoice</th>
        <th>Tanggal Selesai</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($purchase as $item)
      <tr>
        <td>{{ $item->referensi }}</td>
        <td>{{ $item->updated_at }}</td>
        <td>
          <a href="invoice/{{ $item->id }}" class="btn" target="_blank">Cek</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="center">
  <p>____________________________________________________________________________________________________</p>
</div>
<div class="row">
  <div class="some-text">
    <a class="btn btn-input" href="acc-sales/">Cetak Laporan</a>
  </div>
  <table id="sales">
    <thead>
      <tr>
        <th>Invoice</th>
        <th>Tanggal Selesai</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($sales as $item)
      <tr>
        <td>{{ $item->referensi }}</td>
        <td>{{ $item->updated_at }}</td>
        <td>
          <a href="struct/{{ $item->id }}" class="btn" target="_blank">Invoice</a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection