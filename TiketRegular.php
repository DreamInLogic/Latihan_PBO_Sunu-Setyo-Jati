<?php
require_once 'Tiket.php';

class TiketRegular extends Tiket {
    // Properti tambahan (camelCase & ter-enkapsulasi private)
    private $tipeAudio;
    private $lokasiBaris;

    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket, $tipeAudio, $lokasiBaris) {
        // Meneruskan data ke constructor class induk (Tiket)
        parent::__construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket);
        $this->tipeAudio = $tipeAudio;
        $this->lokasiBaris = $lokasiBaris;
    }

    // Getter & Setter untuk properti tambahan
    public function getTipeAudio() { return $this->tipeAudio; }
    public function setTipeAudio($tipeAudio) { $this->tipeAudio = $tipeAudio; }

    public function getLokasiBaris() { return $this->lokasiBaris; }
    public function setLokasiBaris($lokasiBaris) { $this->lokasiBaris = $lokasiBaris; }

    // Implementasi Method Abstrak Induk
    public function hitungTotalHarga() {
        $tambahanAudio = ($this->tipeAudio == 'Dolby Atmos' || $this->tipeAudio == 'DTS:X') ? 10000 : 0;
        return $this->HargaDasarTiket + $tambahanAudio;
    }

    public function tampilkanInfoFasilitas() {
        $audio = $this->tipeAudio ?? "Standard Audio";
        $baris = $this->lokasiBaris ?? "Semua Baris";
        return "Studio Regular [Audio: $audio, Kursi: $baris]";
    }
}
?>