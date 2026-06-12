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

$kelompokTiket = ['Regular' => [], 'IMAX' => [], 'Velvet' => []];
$semuaTiket = []; 
$totalPendapatan = 0;
$totalKursiTerjual = 0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if ($row['jenis_studio'] === 'Regular') {
        $tiket = new TiketRegular($row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], $row['jumlah_kursi'], $row['harga_dasar_tiket'], $row['tipe_audio'], $row['lokasi_baris']);
    } elseif ($row['jenis_studio'] === 'IMAX') {
        $tiket = new TiketIMAX($row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], $row['jumlah_kursi'], $row['harga_dasar_tiket'], $row['kacamata_3d_id'], $row['efek_gerak_fitur']);
    } elseif ($row['jenis_studio'] === 'Velvet') {
        $tiket = new TiketVelvet($row['id_tiket'], $row['nama_film'], $row['jadwal_tayang'], $row['jumlah_kursi'], $row['harga_dasar_tiket'], $row['bantal_selimut_pack'], $row['layanan_butler']);
    }
    
    $kelompokTiket[$row['jenis_studio']][] = $tiket;
    $semuaTiket[] = $tiket;
    
    $totalPendapatan += $tiket->hitungTotalHarga();
    $totalKursiTerjual += $tiket->getJumlahKursi();
}

$totalTransaksi = count($semuaTiket);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminLTE 4 - Bioskop Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <style>
        body { font-family: 'Source Sans Pro', sans-serif; background-color: #f4f6f9; margin: 0; padding: 0; overflow-x: hidden; }
        .wrapper { display: flex; width: 100%; min-height: 100vh; align-items: stretch; }
        
        /* Sidebar AdminLTE Style */
        .sidebar { min-width: 260px; max-width: 260px; background: #343a40; color: #fff; min-height: 100vh; position: sticky; top: 0; z-index: 100; }
        .sidebar .brand-link { padding: 15px; display: block; font-size: 1.25rem; text-decoration: none; color: #fff; border-bottom: 1px solid #4b545c; background: #22252a; }
        .sidebar .user-panel { padding: 15px; border-bottom: 1px solid #4b545c; }
        .sidebar .nav-header { padding: 10px 20px; font-size: 11px; text-transform: uppercase; color: #6c757d; font-weight: bold; }
        .sidebar ul li a { padding: 12px 20px; display: block; color: #c2c7d0; text-decoration: none; transition: all 0.2s; cursor: pointer; }
        .sidebar ul li a:hover { background: #495057; color: #fff; }
        
        /* State Menu Aktif */
        .sidebar ul li a.active { background: #0d6efd; color: #fff !important; font-weight: bold; }
        
        /* FIX UTAMA: Mencegah Konten Kanan Melebar & Memotong Layar */
        .content-wrapper { flex: 1; min-width: 0; padding: 25px; background-color: #f4f6f9; }
        .content-header { margin-bottom: 25px; border-bottom: 1px solid #dee2e6; padding-bottom: 10px; }
        
        /* AdminLTE Card Customization */
        .card { border-radius: 0.25rem; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); border: none; margin-bottom: 2rem; width: 100%; }
        
        /* Small Box AdminLTE 4 */
        .small-box { position: relative; display: block; border-radius: 0.25rem; color: #fff; padding: 20px; margin-bottom: 20px; overflow: hidden; box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2); }
        .small-box .inner h3 { font-size: 1.8rem; font-weight: 700; margin: 0 0 10px 0; white-space: nowrap; }
        .small-box .icon { position: absolute; top: 15px; right: 15px; z-index: 0; font-size: 60px; color: rgba(0,0,0,0.15); }
        
        /* Pengaturan Penayangan Filter Tabel SPA */
        .table-section { display: none; width: 100%; }
        .table-section.active-table { display: block; }

        /* Memaksa pembungkus tabel agar responsive scroll jika kolom terlalu lebar */
        .custom-table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    </style>
</head>
<body>

<div class="wrapper">
    <nav class="sidebar">
        <a href="#" class="brand-link text-center fw-bold">
            <i class="fa-solid fa-film me-2 text-primary"></i>TRPL Cinema
        </a>
        <div class="user-panel text-center">
            <div class="info">
                <a href="#" class="d-block text-decoration-none text-white fw-semibold">
                    <i class="fa-solid fa-user-shield me-2 text-warning"></i>Sunu Setyo Jati
                </a>
                <span class="badge bg-success mt-1" style="font-size: 10px;">Admin TRPL 1A</span>
            </div>
        </div>
        
        <ul class="list-unstyled mt-2" id="sidebar-menu">
            <li>
                <a class="nav-link-custom active" data-target="sekilas-data">
                    <i class="nav-icon fas fa-tachometer-alt me-2"></i> Dashboard Utama
                </a>
            </li>
            
            <div class="nav-header">Filter Studio</div>
            <li>
                <a class="nav-link-custom" data-target="studio-Regular">
                    <i class="fa-solid fa-film me-2 text-primary"></i> Studio Regular
                    <span class="badge bg-primary float-end fs-8"><?= count($kelompokTiket['Regular']); ?></span>
                </a>
            </li>
            <li>
                <a class="nav-link-custom" data-target="studio-IMAX">
                    <i class="fa-solid fa-bolt me-2 text-warning"></i> Studio IMAX
                    <span class="badge bg-warning text-dark float-end fs-8"><?= count($kelompokTiket['IMAX']); ?></span>
                </a>
            </li>
            <li>
                <a class="nav-link-custom" data-target="studio-Velvet">
                    <i class="fa-solid fa-couch me-2 text-purple"></i> Studio Velvet
                    <span class="badge bg-purple float-end fs-8"><?= count($kelompokTiket['Velvet']); ?></span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="content-wrapper">
        
        <div class="content-header d-flex justify-content-between align-items-center">
            <h1 class="m-0 fs-3 text-dark fw-bold">Cinema Analytics Dashboard</h1>
            <div class="text-secondary fs-7">Developer: Sunu Setyo Jati</div>
        </div>

        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?= $totalTransaksi; ?></h3>
                            <p>Total Pesanan Tiket</p>
                        </div>
                        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?></h3>
                            <p>Total Pendapatan</p>
                        </div>
                        <div class="icon"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box bg-warning text-white">
                        <div class="inner">
                            <h3><?= $totalKursiTerjual; ?></h3>
                            <p>Kursi Terisi</p>
                        </div>
                        <div class="icon"><i class="fas fa-chair"></i></div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 col-12">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>3</h3>
                            <p>Tipe Studio Aktif</p>
                        </div>
                        <div class="icon"><i class="fas fa-clapperboard"></i></div>
                    </div>
                </div>
            </div>

            <div id="table-container" class="mt-4">
                
                <div id="sekilas-data" class="table-section active-table">
                    <div class="card shadow-sm border-top border-3 border-dark">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title m-0 fs-5 fw-bold text-dark">
                                <i class="fa-solid fa-chart-pie me-2 text-secondary"></i>Sekilas Data Transaksi Terbaru (Semua Studio)
                            </h3>
                        </div>
                        <div class="card-body p-0 custom-table-responsive">
                            <table class="table table-striped table-hover align-middle m-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Nama Film</th>
                                        <th>Jadwal Tayang</th>
                                        <th>Jumlah Kursi</th>
                                        <th>Studio Class</th>
                                        <th class="pe-3">Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($semuaTiket)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada transaksi di database.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php 
                                        $sekilas = array_slice($semuaTiket, 0, 5); 
                                        foreach ($sekilas as $tiket): 
                                            $studioName = str_replace('Tiket', '', get_class($tiket));
                                            $bgClass = ($studioName === 'Regular') ? 'bg-primary' : (($studioName === 'IMAX') ? 'bg-warning text-dark' : 'bg-purple text-white');
                                        ?>
                                            <tr>
                                                <td class="ps-3">#<?= $tiket->getIdTiket(); ?></td>
                                                <td class="fw-bold"><?= $tiket->getNamaFilm(); ?></td>
                                                <td><?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                                                <td><?= $tiket->getJumlahKursi(); ?> Kursi</td>
                                                <td><span class="badge <?= $bgClass; ?>"><?= $studioName; ?></span></td>
                                                <td class="pe-3 text-success fw-bold">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <div class="p-3 bg-light text-center fs-7 text-secondary">
                                Menampilkan ringkasan transaksi terbaru. Gunakan menu <strong>Filter Studio</strong> untuk data penuh dan detail fasilitas polimorfisme.
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                $cardThemes = [
                    'Regular' => ['border' => 'border-top: 3px solid #0d6efd', 'badge' => 'bg-primary'],
                    'IMAX'    => ['border' => 'border-top: 3px solid #fd7e14', 'badge' => 'bg-warning text-dark'],
                    'Velvet'  => ['border' => 'border-top: 3px solid #6f42c1', 'badge' => 'bg-purple text-white']
                ];
                
                foreach ($kelompokTiket as $studio => $daftarTiket): 
                    $theme = $cardThemes[$studio];
                ?>
                    <div id="studio-<?= $studio; ?>" class="table-section">
                        <div class="card shadow-sm" style="<?= $theme['border']; ?>">
                            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                <h3 class="card-title m-0 fs-5 fw-bold text-dark">
                                    <i class="fa-solid fa-layer-group me-2 text-secondary"></i>Manajemen Data - Studio <?= $studio; ?>
                                </h3>
                                <span class="badge <?= $theme['badge']; ?> px-3 py-2 rounded-pill fs-7">
                                    Studio <?= $studio; ?> Class
                                </span>
                            </div>
                            <div class="card-body p-0 custom-table-responsive">
                                <table class="table table-striped table-hover align-middle m-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3" style="width: 5%">ID</th>
                                            <th style="width: 20%">Nama Film</th>
                                            <th style="width: 15%">Jadwal Tayang</th>
                                            <th style="width: 10%">Jumlah Kursi</th>
                                            <th style="width: 12%">Harga Dasar</th>
                                            <th style="width: 25%">Fasilitas Spesifik (Polimorfik)</th>
                                            <th class="pe-3" style="width: 13%">Total Harga (Overriding)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($daftarTiket)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">Tidak ada data transaksi untuk kategori ini.</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($daftarTiket as $tiket): ?>
                                                <tr>
                                                    <td class="ps-3 text-secondary">#<?= $tiket->getIdTiket(); ?></td>
                                                    <td class="fw-bold text-dark"><?= $tiket->getNamaFilm(); ?></td>
                                                    <td><i class="far fa-clock text-muted me-1"></i> <?= date('d M Y - H:i', strtotime($tiket->getJadwalTayang())); ?> WIB</td>
                                                    <td><span class="badge bg-light text-dark border"><i class="fa-solid fa-couch me-1 text-secondary"></i> <?= $tiket->getJumlahKursi(); ?></span></td>
                                                    <td>Rp <?= number_format($tiket->getHargaDasarTiket(), 0, ',', '.'); ?></td>
                                                    <td class="text-muted"><i class="fa-solid fa-wand-magic-sparkles text-info me-1"></i> <em><?= $tiket->tampilkanInfoFasilitas(); ?></em></td>
                                                    <td class="pe-3 fw-bold text-success">Rp <?= number_format($tiket->hitungTotalHarga(), 0, ',', '.'); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                
            </div> </div>
    </div>
</div>

<script>
document.querySelectorAll('.nav-link-custom').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); 
        document.querySelectorAll('.nav-link-custom').forEach(item => item.classList.remove('active'));
        this.classList.add('active');
        document.querySelectorAll('.table-section').forEach(section => section.classList.remove('active-table'));
        const targetId = this.getAttribute('data-target');
        document.getElementById(targetId).classList.add('active-table');
    });
});
</script>

</body>
</html>