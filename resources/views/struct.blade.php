<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .purchase-order-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 40px;
            padding-bottom: 60px;
            padding-left: 30px;
            padding-right: 30px;
            border: 1px solid #ccc;
        }

        .purchase-order-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .purchase-order-logo {
            text-align: left;
            
        }

        .purchase-order-logo img {
            max-width: 100px; /* Sesuaikan dengan ukuran logo Anda */
            height: auto;
        }

        .purchase-order-details {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .purchase-order-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .purchase-order-items th, .purchase-order-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .purchase-order-total {
            text-align: right;
            font-weight: bold;
            padding-right: 40px;
        }

        .purchase-order-Amount {
            text-align: right;
            font-weight: bold;
            padding-right: 50px;
        }
        .Underlined {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="purchase-order-container">
        <div class="purchase-order-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Company Logo">
        </div>
        <div class="purchase-order-header">
            <h2>Struk #{{ $sales->referensi }}</h2>
        </div>
        <div class="purchase-order-details">
            <div>
                <p><strong>Konsumen:</strong> {{ $sales->customer['nama'] }}</p>
                <p>{{ $sales->customer['alamat'] }}</p>
                <p>{{ $sales->customer->kab['nama'] }}</p>
                <p>{{ $sales->customer->prov['nama'] }}</p>
            </div>
        </div>

        <table class="purchase-order-items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales->product as $data)
                    <tr>
                        <td>{{ $data->nama }}</td>
                        <td>{{ $data->pivot->jumlah }}</td>
                        <td>{{ format_uang($data->harga) }}</td>
                        <td>{{ format_uang($data->harga * $data->pivot->jumlah) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="Underlined">
            <p>__________________________________</p>
        </div>
        <div class="purchase-order-total">
            <p>Total Pembelian: {{ format_uang($sales->total) }}</p>
        </div>
        <div class="purchase-order-total">
            <p>Dikirim: {{ date('d-m-Y', strtotime($sales->updated_at)) }}</p>
        </div>
        <div class="Underlined">
            <p>__________________________________</p>
        </div>
        <div class="purchase-order-Amount">
            <p>Metode Pembayaran: {{ $sales->pembayaran }}</p>
        </div>
    </div>
</body>

</html>