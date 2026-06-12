<?php
abstract class Tiket {
    // Atribut ter-encapsulasi (protected)
    protected $id_tiket;
    protected $nama_film;
    protected $jadwal_tayang;
    protected $jumlah_kursi;
    protected $HargaDasarTiket; // Dipetakan dari harga_dasar_tiket di database

    // Constructor untuk inisialisasi data global
    public function __construct($id_tiket, $nama_film, $jadwal_tayang, $jumlah_kursi, $HargaDasarTiket) {
        $this->id_tiket = $id_tiket;
        $this->nama_film = $nama_film;
        $this->jadwal_tayang = $jadwal_tayang;
        $this->jumlah_kursi = $jumlah_kursi;
        $this->HargaDasarTiket = $HargaDasarTiket;
    }

    // ========================================================
    // GETTER & SETTER (ENKAPSULASI)
    // ========================================================
    public function getIdTiket() { return $this->id_tiket; }
    public function setIdTiket($id_tiket) { $this->id_tiket = $id_tiket; }

    public function getNamaFilm() { return $this->nama_film; }
    public function setNamaFilm($nama_film) { $this->nama_film = $nama_film; }

    public function getJadwalTayang() { return $this->jadwal_tayang; }
    public function setJadwalTayang($jadwal_tayang) { $this->jadwal_tayang = $jadwal_tayang; }

    public function getJumlahKursi() { return $this->jumlah_kursi; }
    public function setJumlahKursi($jumlah_kursi) { $this->jumlah_kursi = $jumlah_kursi; }

    public function getHargaDasarTiket() { return $this->HargaDasarTiket; }
    public function setHargaDasarTiket($HargaDasarTiket) { $this->HargaDasarTiket = $HargaDasarTiket; }

    // ========================================================
    // ABSTRACT METHODS (Wajib diimplementasikan di Class Anak)
    // ========================================================
    
    /**
     * Menghitung total harga tiket setelah ditambah biaya tambahan studio / pajak
     * @return float
     */
    abstract public function hitungTotalHarga();

    /**
     * Menampilkan informasi fasilitas spesifik yang didapatkan dari jenis studio
     * @return string
     */
    abstract public function tampilkanInfoFasilitas();
}
?>