@extends('layout.admin')
@section('title', 'Akuntansi')
@section('content')
<div class="subheader">
  Pembelian
</div>
<div class="some-text">
  <a class="btn btn-input" href="/accPurchase" target="_blank">Cetak Laporan</a>
</div>
@php
    $totalPurchase = 0;
@endphp
<table id="purchase">
  <thead>
    <tr>
      <th>Invoice</th>
      <th>Tanggal Selesai</th>
      <th>Total</th>
      <th>Metode Pembayaran</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($purchase as $item)
    <tr>
      <td>{{ $item->referensi }}</td>
      <td>{{ date('d-m-Y', strtotime($item->updated_at)) }}</td>
      <td>{{ format_uang($item->total) }}</td>
      <td>{{ $item->pembayaran }}</td>
      <td>
        <a href="invoice/{{ $item->id }}" class="btn" target="_blank">Cek</a>
      </td>
    </tr>
      @php
        $totalPurchase += $item->total;
      @endphp
    @endforeach
  </tbody>
</table>
<div class="center">
  Total keseluruhan pembelian: {{ format_uang($totalPurchase) }}
</div>
<div class="center">
  <p>____________________________________________________________________________________________________</p>
</div>
<div class="subheader">
  Penjualan
</div>
<div class="some-text">
  <a class="btn btn-input" href="/accSales" target="_blank">Cetak Laporan</a>
</div>
@php
    $totalSales = 0;
@endphp
<table id="sales">
  <thead>
    <tr>
      <th>Invoice</th>
      <th>Tanggal Selesai</th>
      <th>Total</th>
      <th>Metode Pembayaran</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($sales as $item)
      <tr>
        <td>{{ $item->referensi }}</td>
        <td>{{ date('d-m-Y', strtotime($item->updated_at)) }}</td>
        <td>{{ format_uang($item->total) }}</td>
        <td>{{ $item->pembayaran }}</td>
        <td>
          <a href="struct/{{ $item->id }}" class="btn" target="_blank">Invoice</a>
        </td>
      </tr>
      @php
        $totalSales += $item->total;
      @endphp
    @endforeach
  </tbody>
</table>
<div class="center">
  Total keseluruhan penjualan: {{ format_uang($totalSales) }}
</div>
@endsection