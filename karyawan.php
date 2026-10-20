<?php
class karyawan {
    // Mengubah private menjadi protected agar class anak (karyawantetap/kontrak) 
    // bisa mengakses properti $gajipokok untuk perhitungan total gaji
    protected $nama;
    protected $nik;
    protected $gajipokok;

    public function __construct($nama, $nik, $gajipokok) {
        $this->nama = $nama;
        $this->nik = $nik;
        $this->gajipokok = $gajipokok;
    }
    
    public function getinfo() {
        return "Nama: " . $this->nama . "<br>" .
               "NIK: " . $this->nik . "<br>" .
               "Gaji Pokok: Rp. " . number_format($this->gajipokok, 0, ',', '.') . "<br>";
    }
}

class karyawantetap extends karyawan {
    // Mendeklarasikan seluruh properti dengan benar agar tidak error deprecated
    private $tunjangan;
    private $pajak;

    public function __construct($nama, $nik, $gajipokok, $tunjangan) {
        parent::__construct($nama, $nik, $gajipokok);
        $this->tunjangan = $tunjangan;
        // Pajak otomatis dihitung 5% (0.05) langsung dari $gajipokok
        $this->pajak = 0.05 * $gajipokok; 
    }

    public function getinfo() {
        // Tanda titik koma (;) dipindahkan ke bagian paling akhir agar "total Gaji" ikut tercetak
        return parent::getinfo() .
               "Tunjangan: Rp. " . number_format($this->tunjangan, 0, ',', '.') . "<br>" .
               "Pajak: Rp. " . number_format($this->pajak, 0, ',', '.') . "<br>" .
               "Total Gaji: Rp. " . number_format($this->gajipokok + $this->tunjangan - $this->pajak, 0, ',', '.') . "<br>";    
    }
}

class karyawankontrak extends karyawan {
    // Mendeklarasikan seluruh properti dengan benar agar tidak error deprecated
    private $durasikontrak;
    private $lembur;
    private $pajak;

    public function __construct($nama, $nik, $gajipokok, $durasikontrak, $jam_lembur) {
        parent::__construct($nama, $nik, $gajipokok);
        $this->durasikontrak = $durasikontrak;
        // Lembur otomatis dihitung 2% (0.02) dari $gajipokok dikali jumlah jam lembur
        $this->lembur = (0.02 * $gajipokok) * $jam_lembur; 
        // Pajak otomatis dihitung 0% dari $gajipokok
        $this->pajak = 0.00 * $gajipokok; 
    }

    public function getinfo() {
        return parent::getinfo() .
               "Durasi Kontrak: " . $this->durasikontrak . " bulan <br>" .
               "Uang Lembur: Rp. " . number_format($this->lembur, 0, ',', '.') . "<br>" .
               "Pajak: Rp. " . number_format($this->pajak, 0, ',', '.') . "<br>" .
               "Total Gaji: Rp. " . number_format($this->gajipokok + $this->lembur - $this->pajak, 0, ',', '.') . "<br>";
    }
}

// Mengurangi jumlah argumen saat instansiasi karena Pajak & Lembur sudah dihitung otomatis berdasarkan rumus persenan di atas
$karyawantetap = new karyawantetap("Budi", "123456789", 5000000, 1000000);
$karyawankontrak = new karyawankontrak("Siti", "987654321", 3000000, 12, 5); // 5 jam lembur

echo "<h2>Informasi Karyawan Tetap</h2>";
echo $karyawantetap->getinfo();

echo "<h2>Informasi Karyawan Kontrak</h2>";
echo $karyawankontrak->getinfo();
?>
