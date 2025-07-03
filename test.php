<!DOCTYPE html>
<html>
<head>
    <title>Kombinasi Soal PHP Native</title>
</head>
<body>
    <form method="post">
        <label>Soal (masukkan nilai tiap-tiap pertanyaan dalam soal yang dipisah dengan koma, maksimal 10 pertanyaan):</label><br>
        <input type="text" name="soal" size="80" required><br><br>

        <label>T: </label>
        <input name="target" required>
        <input type="submit" name="submit" value="Hitung">
    </form>

<?php
function cariKombinasi($soal, $target, $index = 0, $kombinasi = [], &$hasil = []) {
    if ($target == 0) {
        $hasil[] = $kombinasi;
        return;
    }

    if ($target < 0 || $index >= count($soal)) {
        return;
    }

    // Ambil soal
    $kombinasi[] = $index;
    cariKombinasi($soal, $target - $soal[$index], $index + 1, $kombinasi, $hasil);

    // Lewati soal
    array_pop($kombinasi);
    cariKombinasi($soal, $target, $index + 1, $kombinasi, $hasil);
}

if (isset($_POST['submit'])) {
    $input = $_POST['soal'];
    $target = (int)$_POST['target'];
    $soal = array_map('intval', explode(',', $input));

    if (count($soal) > 10) {
        echo "<p style='color:red;'>Maksimal hanya boleh 10 soal!</p>";
        return;
    }

    echo "<hr><b>SOAL</b><br><pre>";
    foreach ($soal as $i => $poin) {
        printf("[Pertanyaan %d] => %d\n", $i+1, $poin);
    }
    echo "</pre>";
    echo "dengan Nilai Total Soal (T) = <b>$target</b> ?<br><br>";

    echo "<b>JAWABAN</b><br>";
    $hasil = [];
    cariKombinasi($soal, $target, 0, [], $hasil);

    echo "Jumlah semua Kombinasi (K) = <b>" . count($hasil) . "</b><br><br>";
    echo "Daftar Kombinasi:<br><pre>";
    foreach ($hasil as $i => $komb) {
        echo "[$i] => Array\n(\n";
        foreach ($komb as $k) {
            printf("    [Pertanyaan %d] => %d\n", $k+1, $soal[$k]);
        }
        echo ")\n\n";
    }
    echo "</pre>";
}
?>
</body>
</html>
