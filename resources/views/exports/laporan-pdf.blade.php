<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; font-size: 11px; }
        h1 { text-align: center; color: #333; margin-bottom: 10px; }
        .header { margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .date { text-align: right; color: #666; font-size: 11px; }
        .summary { display: flex; justify-content: space-around; margin: 20px 0; }
        .summary-box { border: 2px solid #ddd; padding: 15px; text-align: center; flex: 1; margin: 0 10px; }
        .summary-box h3 { margin: 0; font-size: 14px; color: #666; }
        .summary-box p { margin: 10px 0 0 0; font-size: 18px; font-weight: bold; }
        .penjualan { color: #4CAF50; }
        .pembelian { color: #f44336; }
        .selisih { color: #2196F3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background-color: #607D8B; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .print-btn { margin-top: 20px; padding: 10px 20px; background: #607D8B; color: white; border: none; cursor: pointer; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KEUANGAN</h1>
        <p class="date">Dicetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="summary">
        <div class="summary-box">
            <h3>Total Penjualan</h3>
            <p class="penjualan">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box">
            <h3>Total Pembelian</h3>
            <p class="pembelian">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</p>
        </div>
        <div class="summary-box">
            <h3>Selisih</h3>
            <p class="selisih">{{ $selisih >= 0 ? '+' : '' }} Rp {{ number_format($selisih, 0, ',', '.') }}</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 40%;">Deskripsi</th>
                <th style="width: 20%;">Nominal</th>
                <th style="width: 15%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanData as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong style="color: {{ $item['type'] == 'penjualan' ? '#4CAF50' : '#f44336' }}">{{ $item['kategori'] }}</strong></td>
                <td>{{ $item['deskripsi'] }}</td>
                <td style="color: {{ $item['type'] == 'penjualan' ? '#4CAF50' : '#f44336' }}">
                    <strong>{{ $item['type'] == 'penjualan' ? '+' : '-' }} Rp {{ number_format($item['nominal'], 0, ',', '.') }}</strong>
                </td>
                <td>{{ $item['tanggal'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <p style="margin-top: 20px; font-size: 11px; color: #666;">Total: {{ $laporanData->count() }} transaksi</p>
    
    <button class="print-btn" onclick="window.print()">Print / Save as PDF</button>
</body>
</html>
