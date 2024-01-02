@extends('layout.admin')
@section('title', 'Penjualan')
@section('content')
<div class="some-text">
    <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
    <div class="popup__content">
        <form action="/sales" method="post">
            @csrf
            <div class="row">
                <h2>Penjualan</h2>
                <div class="input-group">
                    <select name="customer_id">
                        <option value="">Pilih Konsumen</option>
                        @foreach ($customer as $cus)
                            <option value="{{ $cus->id }}">{{ $cus->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="inputMaterials">
                    <div>
                        <div class="col-third">
                            <label>Produk</label>
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
                            <select name="product_id[]">
                                <option value="">Pilih Produk</option>
                                @foreach ($product as $pro)
                                    <option value="{{ $pro->id }}" data-harga="{{ $pro->harga }}">{{ $pro->nama }}</option>
                                @endforeach
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
                <div class="input-group">
                    <label>Total</label>
                    <input type="number" id="totalPriceInput" name="total" readonly/>
                </div>
            </div>
            <a href="#" class="btn">Close</a>
            <button type="submit" class="btn">Order</button>
        </form>
    </div>
</div>
<table id="sales">
    <thead>
        <tr>
            <th>Referensi</th>
            <th>Konsumen</th>
            <th>Produk</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $item)
        <tr>
            <td>{{ $item->referensi }}</td>
            <td>{{ $item->customer['nama'] }}</td>
            <td>
                @foreach ($item->product as $data)
                    => {{ $data->nama }} <br>
                @endforeach
            </td>
            <td>
                @foreach ($item->product as $data)
                    => {{ format_uang($data->harga) }} <br>
                @endforeach
            </td>
            <td>
                @foreach ($item->product as $data)
                    => {{ $data->pivot->jumlah }} <br>
                @endforeach
            </td>
            <td>{{ format_uang($item->total) }}</td>
            <td>{{ $item->pembayaran }}</td>
            <td>
                @if ($item->status == 'order')
                    <a href="" class="btn">Kirim Tagihan</a> | <a href="#pay{{ $item->id }}" onclick="tampilkanModal({{ $item->id }})" class="btn">Pembayaran</a> | <a href="#cancel{{ $item->id }}" class="btn">Batal</a>
                @elseif($item->status == 'pay')
                    <a href="#delivery{{ $item->id }}" class="btn">Kirim</a>
                @elseif($item->status == 'delivery')
                    <a href="struct/{{ $item->id }}" class="btn" target="_blank">Invoice</a>
                @endif
            </td>
        </tr>
        {{-- MODAL CANCEL --}}
        <div class="popup" id="cancel{{ $item->id }}">
            <div class="popup__content">
                <form action="cancel/{{ $item->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <p class="popup__text">
                        Yakin ingin membatalkan pesanan atas nama {{ $item->customer['nama'] }}?
                    </p>
                    <a href="#" class="btn">Close</a>
                    <button type="submit" class="btn">Konfirmasi</button>
                </form>
            </div>
        </div>
        {{-- MODAL DELIVERY --}}
        <div class="popup" id="delivery{{ $item->id }}">
            <div class="popup__content">
                <form action="delivery/{{ $item->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <p class="popup__text">
                        Yakin ingin mengirim pesanan atas nama {{ $item->customer['nama'] }}?
                    </p>
                    <a href="#" class="btn">Close</a>
                    <button type="submit" class="btn">Konfirmasi</button>
                </form>
            </div>
        </div>
        {{-- MODAL PAYMENT --}}
        <div class="popup" id="pay{{ $item->id }}">
            <div class="popup__content">
                <form action="pay/{{ $item->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <h2>Metode Pembayaran</h2>
                        <div class="center">
                            <div class="wrapper">
                                <input type="radio" name="pembayaran" id="option-1" value="Transfer">
                                <input type="radio" name="pembayaran" id="option-2" value="Tunai">
                                    <label for="option-1" class="option option-1">
                                        <div class="dot"></div>
                                        <span>Transfer</span>
                                    </label>
                                    <label for="option-2" class="option option-2">
                                        <div class="dot"></div>
                                        <span>Tunai</span>
                                  </label>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn">Close</a>
                    <button type="submit" class="btn">Bayar</button>
                </form>
            </div>
            </div>
        </div>
        @endforeach
    </tbody>
</table>
@endsection