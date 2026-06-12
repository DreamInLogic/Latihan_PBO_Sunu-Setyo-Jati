<?php
require_once 'Tiket.php';

class TiketVelvet extends Tiket {
    // Properti tambahan (camelCase & ter-enkapsulasi private)
    private $bantalSelimut;
    private $layananButler;

    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket, $bantalSelimut, $layananButler) {
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket);
        $this->bantalSelimut = $bantalSelimut;
        $this->layananButler = $layananButler;
    }

    // Getter & Setter untuk properti tambahan
    public function getBantalSelimut() { return $this->bantalSelimut; }
    public function setBantalSelimut($bantalSelimut) { $this->bantalSelimut = $bantalSelimut; }

    public function getLayananButler() { return $this->layananButler; }
    public function setLayananButler($layananButler) { $this->layananButler = $layananButler; }

    // Implementasi Method Abstrak Induk
    public function hitungTotalHarga() {
        $biayaVelvet = 50000;
        return $this->HargaDasarTiket + $biayaVelvet;
    }

    public function tampilkanInfoFasilitas() {
        $pack = $this->bantalSelimut ?? "Standard Pillow";
        $butler = $this->layananButler ?? "Tidak Ada Pelayan Privat";
        return "Studio Velvet [Sofa Bed, Fasilitas: $pack, Layanan: $butler]";
    }
}
?>