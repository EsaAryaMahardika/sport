@extends('layout.admin')
@section('title', 'Pembelian')
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
                    <select name="vendor_id">
                        <option value="">Pilih Vendor</option>
                        @foreach ($vendor as $ven)
                            <option value="{{ $ven->id }}">{{ $ven->nama }}</option>
                        @endforeach
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
                                <option value="">Pilih Bahan Baku</option>
                                @foreach ($materials as $material)
                                    <option value="{{ $material->id }}" data-harga="{{ $material->harga }}">{{ $material->nama }}</option>
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
            <button type="submit" class="btn">Pesan</button>
        </form>
    </div>
</div>
<table id="purchase">
    <thead>
        <tr>
            <th>Referensi</th>
            <th>Vendor</th>
            <th>Bahan Baku</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($purchase as $item)
        <tr>
            <td>{{ $item->referensi }}</td>
            <td>{{ $item->vendor['nama'] }}</td>
            <td>
                @foreach ($item->materials as $data)
                    => {{ $data->nama }} <br>
                @endforeach
            </td>
            <td>
                @foreach ($item->materials as $data)
                    => {{ format_uang($data->harga) }} <br>
                @endforeach
            </td>
            <td>
                @foreach ($item->materials as $data)
                    => {{ $data->pivot->jumlah }} <br>
                @endforeach
            </td>
            <td>{{ format_uang($item->total) }}</td>
            <td>{{ $item->pembayaran }}</td>
            <td>
                @if ($item->status == 'PO')
                    <a href="" class="btn">Kirim E-mail</a> | <a href="#confirm{{ $item->id }}" class="btn">Terima</a>
                @elseif($item->status == 'confirm')
                    <a href="#payment{{ $item->id }}" class="btn">Pembayaran</a>
                @elseif($item->status == 'payment')
                    <a href="invoice/{{ $item->id }}" class="btn" target="_blank">Invoice</a>
                @endif
            </td>
        </tr>
        {{-- MODAL CONFIRM --}}
        <div class="popup" id="confirm{{ $item->id }}">
            <div class="popup__content">
                <form action="confirm/{{ $item->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <p class="popup__text">
                        Yakin ingin konfirmasi kedatangan pesanan?
                    </p>
                    <a href="#" class="btn">Close</a>
                    <button type="submit" class="btn">Konfirmasi</button>
                </form>
            </div>
        </div>
        {{-- MODAL PAYMENT --}}
        <div class="popup" id="payment{{ $item->id }}">
            <div class="popup__content">
                <form action="payment/{{ $item->id }}" method="POST">
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