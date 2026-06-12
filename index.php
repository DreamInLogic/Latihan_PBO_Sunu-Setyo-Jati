<?php
// 1. Include semua file class yang dibutuhkan
require_once 'Koneksi.php';
require_once 'TiketRegular.php';
require_once 'TiketIMAX.php';
require_once 'TiketVelvet.php';

// 2. Inisialisasi Koneksi ke Database
$database = new Koneksi();
$db = $database->getKoneksi();

// 3. Ambil seluruh data dari tabel_tiket
$query = "SELECT * FROM tabel_tiket";
$stmt = $db->prepare($query);
$stmt->execute();

// 4. Kelompokkan objek langsung berdasarkan Jenis Studio
$kelompokTiket = [
    'Regular' => [],
    'IMAX'    => [],
    'Velvet'  => []
];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['jenis_studio'] === 'Regular') {
        $kelompokTiket['Regular'][] = new TiketRegular(
            $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
            $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
            $row['tipe_audio'], $row['lokasi_baris']
        );
    } elseif ($row['jenis_studio'] === 'IMAX') {
        $kelompokTiket['IMAX'][] = new TiketIMAX(
            $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
            $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
            $row['kacamata_3d_id'], $row['efek_gerak_fitur']
        );
    } elseif ($row['jenis_studio'] === 'Velvet') {
        $kelompokTiket['Velvet'][] = new TiketVelvet(
            $row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], 
            $row['jumlah_kursi'], $row['harga_dasar_tiket'], 
            $row['bantal_selimut_pack'], $row['layanan_butler']
        );
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pemesanan Tiket - Sunu Setyo Jati</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 40px; background-color: #f8f9fa; color: #333; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        h2 { margin-top: 40px; padding-bottom: 10px; border-bottom: 3px solid; }
        
        /* Warna tema per kelompok */
        .title-regular { color: #2980b9; border-color: #2980b9; }
        .title-imax { color: #d35400; border-color: #d35400; }
        .title-velvet { color: #8e44ad; border-color: #8e44ad; }

        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 30px; background: #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        th, td { padding: 14px 18px; text-align: left; }
        th { color: white; font-weight: 600; text-transform: uppercase; font-size: 13px; }
        
        /* Warna Header Tabel */
        .th-regular { background-color: #2980b9; }
        .th-imax { background-color: #d35400; }
        .th-velvet { background-color: #8e44ad; }

        tr { border-bottom: 1px solid #eeeeee; }
        tr:last-child { border-bottom: none; }
        tr:hover { background-color: #fdfdfd; }
        
        .text-bold { font-weight: bold; }
        .text-muted { color: #7f8c8d; font-style: italic; }
        .price { color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>

    <h1>SISTEM MONITORING TIKET BIOSKOP</h1>
    <p style="text-align: center; font-size: 14px; color: #7f8c8d;">Developer: <strong>Sunu Setyo Jati (TRPL 1A)</strong></p>

    <?php foreach ($kelompokTiket as $studio => $daftarTiket): ?>
        <h2 class="title-<?= strtolower($studio); ?>">Studio <?= $studio; ?> Class</h2>
        
        <table>
            <thead>
                <tr class="th-<?= strtolower($studio); ?>">
                    <th style="width: 5%;">ID</th>
                    <th style="width: 25%;">Nama Film</th>
                    <th style="width: 15%;">Jadwal Tayang</th>
                    <th style="width: 10%;">Jumlah Kursi</th>
                    <th style="width: 12%;">Harga Dasar</th>
                    <th style="width: 20%;">Fasilitas Spesifik (Polimorfik)</th>
                    <th style="width: 13%;">Total Harga (Overriding)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarTiket)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; class='text-muted'">Tidak ada data pesanan untuk Studio <?= $studio; ?>.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarTiket as $tiket): ?>
                        <tr>
                            <td><?= $tiket->getIdTiket(); ?></td>
                            <td class="text-bold"><?= $tiket->getNamaFilm(); ?></td>
                            <td><?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                            <td><?= $tiket->getJumlahKursi(); ?> Kursi</td>
                            <td>Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></td>
                            <td class="text-muted"><?= $tiket->tampilkanInfoFasilitas(); ?></td>
                            <td class="price">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endforeach; ?>

</body>
</html>