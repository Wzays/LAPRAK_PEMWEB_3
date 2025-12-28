<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"

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

        /* Styling tambahan agar mirip hasil penilaian di gambar */
        .hasil-header {
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            border-radius: 5px 5px 0 0;
        }

        .hasil-body {
            background-color: white;
            border: 1px solid #dee2e6;
            padding: 20px;
            border-radius: 0 0 5px 5px;
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
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" value="<?= isset($_POST['nama']) ? $_POST['nama'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" value="<?= isset($_POST['nim']) ? $_POST['nim'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="Untuk Lulus minimal 70%" min="0" max="100" value="<?= isset($_POST['kehadiran']) ? $_POST['kehadiran'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" min="0" max="100" value="<?= isset($_POST['tugas']) ? $_POST['tugas'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" min="0" max="100" value="<?= isset($_POST['uts']) ? $_POST['uts'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" min="0" max="100" value="<?= isset($_POST['uas']) ? $_POST['uas'] : '' ?>">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <?php
                // Logika PHP dimulai di sini
                if (isset($_POST['proses'])) {
                    $nama = $_POST['nama'];
                    $nim = $_POST['nim'];
                    $kehadiran = $_POST['kehadiran'];
                    $tugas = $_POST['tugas'];
                    $uts = $_POST['uts'];
                    $uas = $_POST['uas'];

                    // 1. Cek apakah ada kolom yang kosong 
                    if (empty($nama) || empty($nim) || $kehadiran == "" || $tugas == "" || $uts == "" || $uas == "") {
                        echo '
                        <div class="alert alert-danger mt-3" role="alert">
                            Semua kolom harus diisi!
                        </div>';
                    } else {
                        // 2. Hitung Nilai Akhir sesuai bobot
                        $nilai_akhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4);

                        // 3. Tentukan Grade berdasarkan rentang nilai
                        if ($nilai_akhir >= 85) { $grade = "A"; }
                        elseif ($nilai_akhir >= 70) { $grade = "B"; }
                        elseif ($nilai_akhir >= 55) { $grade = "C"; }
                        elseif ($nilai_akhir >= 40) { $grade = "D"; }
                        else { $grade = "E"; }

                        // 4. Syarat Kelulusan Kompleks
                        // Syarat: NA >= 60, Absen > 70, dan semua komponen >= 40
                        $is_lulus = ($nilai_akhir >= 60 && $kehadiran > 70 && $tugas >= 40 && $uts >= 40 && $uas >= 40);
                        
                        $status = $is_lulus ? "LULUS" : "TIDAK LULUS";
                        $tema_warna = $is_lulus ? "success" : "danger"; // Hijau jika lulus, Merah jika tidak

                        // 5. Tampilkan Hasil Penilaian 
                        echo "
                        <div class='mt-4'>
                            <div class='hasil-header bg-{$tema_warna}'>Hasil Penilaian</div>
                            <div class='hasil-body shadow-sm'>
                                <div class='row mb-3'>
                                    <div class='col-md-6'><strong>Nama:</strong> {$nama}</div>
                                    <div class='col-md-6 text-md-end'><strong>NIM:</strong> {$nim}</div>
                                </div>
                                <p class='mb-1'>Nilai Kehadiran: {$kehadiran}%</p>
                                <p class='mb-1'>Nilai Tugas: {$tugas}</p>
                                <p class='mb-1'>Nilai UTS: {$uts}</p>
                                <p class='mb-1'>Nilai UAS: {$uas}</p>
                                <p class='mb-1'><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>
                                <p class='mb-1'><strong>Grade:</strong> {$grade}</p>
                                <p class='mb-3'><strong>Status:</strong> <span class='fw-bold text-{$tema_warna}'>{$status}</span></p>
                                div class='d-grid'>
                                <a href='polosan.php' class='btn btn-{$tema_warna}'>Selesai</a>
                            </div>
                            </div>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        ></script>
</body>
</html>
