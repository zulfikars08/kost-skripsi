<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transaksi Data</title>
    <style>
        /* Define your CSS styles here for the PDF or Excel export */
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Transaksi Data</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Kamar</th>
                <th>Nama</th>
                <th>Nama Kos</th>
                <th>Tanggal</th>
                <th>Jumlah Tarif</th>
                <th>Tipe Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>Kebersihan</th>
                <th>Total</th>
                <th>Pengeluaran</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksiData as $row)
                <tr>
                    <td>{{ $row[0] }}</td>
                    <td>{{ $row[1] }}</td>
                    <td>{{ $row[2] }}</td>
                    <td>{{ $row[3] }}</td>
                    <td>{{ $row[4] }}</td>
                    <td>{{ $row[5] }}</td>
                    <td>{{ $row[6] }}</td>
                    <td>{{ $row[7] }}</td>
                    <td>{{ $row[8] }}</td>
                    <td>{{ $row[9] }}</td>
                    <td>{{ $row[10] }}</td>
                    <td>{{ $row[11] }}</td>
                    <td>{{ $row[12] }}</td>
                    <td>{{ $row[13] }}</td>
                    <td>{{ $row[14] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
