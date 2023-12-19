<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produksi</title>
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
            max-width: 100px;
            height: auto;
        }

        .purchase-order-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .purchase-order-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .purchase-order-items th,
        .purchase-order-items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>

    <div class="purchase-order-container">
        <div class="purchase-order-logo">
            <img src="{{ asset('img/logo.png') }}" alt="Company Logo">
        </div>
        <div class="purchase-order-header">
            <h2>Produksi #{{ $production->referensi }}</h2>
        </div>
        <div class="purchase-order-details">
            <div>
                <p><strong>Produsen:</strong> {{ $production->product->factory['nama'] }}</p>
                <p>{{ $production->product->factory['alamat'] }}</p>
                <p>{{ $production->product->factory->kab['nama'] }}</p>
                <p>{{ $production->product->factory->prov['nama'] }}</p>
            </div>
        </div>

        <table class="purchase-order-items">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $production->product->nama }}</td>
                    <td>{{ $production->jumlah }}</td>
                    <td>{{ date('d-m-Y', strtotime($production->mulai)) }}</td>
                    <td>{{ date('d-m-Y', strtotime($production->selesai)) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>