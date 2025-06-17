<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" required>
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Untuk Lulus minimal 70%" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100" required>
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <?php
// Cek apakah tombol "Proses" sudah diklik
if (isset($_POST['proses'])) {
    // Ambil semua input dari form
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $kehadiran = $_POST['kehadiran'];
    $tugas = $_POST['tugas'];
    $uts = $_POST['uts'];
    $uas = $_POST['uas'];

    // Hitung nilai akhir berdasarkan bobot: kehadiran 10%, tugas 20%, UTS 30%, UAS 40%
    $nilai_akhir = ($kehadiran * 0.10) + ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.40);

    // Tentukan grade berdasarkan nilai akhir
    if ($nilai_akhir >= 85) {
        $grade = "A";
    } elseif ($nilai_akhir >= 70) {
        $grade = "B";
    } elseif ($nilai_akhir >= 55) {
        $grade = "C";
    } elseif ($nilai_akhir >= 40) {
        $grade = "D";
    } else {
        $grade = "E";
    }

    // Logika kelulusan:
    // 1. Jika kehadiran < 70% langsung tidak lulus
    // 2. Jika nilai akhir >= 60 dan semua komponen >= 40 → LULUS
    // 3. Selain itu → TIDAK LULUS
    if ($kehadiran < 70) {
        $status = "TIDAK LULUS";
    } elseif ($nilai_akhir >= 60 && $tugas >= 40 && $uts >= 40 && $uas >= 40) {
        $status = "LULUS";
    } else {
        $status = "TIDAK LULUS";
    }

    // Tentukan warna tampilan card dan tombol berdasarkan status kelulusan
    $warna_card = ($status == "LULUS") ? "success" : "danger";
    $warna_btn = ($status == "LULUS") ? "success" : "danger";

    // Tampilkan hasil perhitungan dalam card Bootstrap
    echo "
    <div class='card mt-4 border-$warna_card'>
        <div class='card-header bg-$warna_card text-white'>
            Hasil Penilaian
        </div>
        <div class='card-body'>
            <div class='row mb-2'>
                <div class='col'><strong>Nama:</strong> $nama</div>
                <div class='col text-end'><strong>NIM:</strong> $nim</div>
            </div>
            <p>Nilai Kehadiran: <strong>$kehadiran%</strong></p>
            <p>Nilai Tugas: <strong>$tugas</strong></p>
            <p>Nilai UTS: <strong>$uts</strong></p>
            <p>Nilai UAS: <strong>$uas</strong></p>
            <p>Nilai Akhir: <strong>" . number_format($nilai_akhir, 2) . "</strong></p>
            <p>Grade: <strong>$grade</strong></p>
            <p>Status: <strong>$status</strong></p>

            <!-- Tombol Selesai -->
            <form method='post'>
                <button class='btn btn-$warna_btn'>Selesai</button>
            </form>
        </div>
    </div>
    ";
}
?>
            </div>
        </div>
    </div>
</body>
</html>
