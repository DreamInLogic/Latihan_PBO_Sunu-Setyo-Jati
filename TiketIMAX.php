<?php
require_once 'Tiket.php';

class TiketIMAX extends Tiket {
    // Properti tambahan (camelCase & ter-enkapsulasi private)
    private $kacamata3dId;
    private $efekGerakFitur;

    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket, $kacamata3dId, $efekGerakFitur) {
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket);
        $this->kacamata3dId = $kacamata3dId;
        $this->efekGerakFitur = $efekGerakFitur;
    }

    // Getter & Setter untuk properti tambahan
    public function getKacamata3dId() { return $this->kacamata3dId; }
    public function setKacamata3dId($kacamata3dId) { $this->kacamata3dId = $kacamata3dId; }

    public function getEfekGerakFitur() { return $this->efekGerakFitur; }
    public function setEfekGerakFitur($efekGerakFitur) { $this->efekGerakFitur = $efekGerakFitur; }

    // Ganti method hitungTotalHarga() di file TiketIMAX.php dengan kode ini:
    public function hitungTotalHarga() {
        // Ditambah biaya tambahan teknologi proyeksi IMAX Rp 35.000
        return ($this->jumlah_kursi * $this->HargaDasarTiket) + 35000;
    }
    public function tampilkanInfoFasilitas() {
        $kacamata = ($this->kacamata3dId) ? "Termasuk Kacamata 3D (ID: {$this->kacamata3dId})" : "2D (Tanpa Kacamata)";
        $efek = $this->efekGerakFitur ?? "Tanpa Efek Gerak";
        return "Studio IMAX [Layar Raksasa, $kacamata, Fitur: $efek]";
    }
}
?>