<?php
function vlookup($col, $row, $label)
{
    require('connection.php');

    // hitung jumlah data yang sesuai label dan col
    $jml_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT $col FROM tb_training WHERE play = '$label'"));

    // kondisi data
    $data = mysqli_num_rows(mysqli_query($koneksi, "SELECT $col,play FROM tb_training WHERE $col = '$row' AND play = '$label'"));

    // hitung
    $probabilitas = ($data / $jml_data) * 100;

    // definisikan dan set nilai
    $row = "$row" . "_" . "$label";
    $_SESSION["$row"] = $probabilitas;

    // tampilkan
    return $probabilitas;
}

// Function probabilitas Play (YES/NO)
function probabilitas_play($label)
{
 require('connection.php');
    // jumlah data keseluruhan
 $jml_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT play FROM tb_training"));

    // kondisi data
 $data = mysqli_num_rows(mysqli_query($koneksi, "SELECT play FROM tb_training WHERE play = '$label'"));

    // hitung
 $probabilitas = ($data / $jml_data) * 100;

    // definisikan dan set nilai
 $play = "play_$label";
 $_SESSION["$play"] = $probabilitas;

    // tampilkan
 return $probabilitas;
}

// function Prediksi
function prediksi($outlook, $temperature, $humidity, $windy, $label)
{
    $hitung_prediksi = (($outlook / 100) * ($temperature / 100) * ($humidity / 100) * ($windy / 100) * ($label / 100)) * 100;

    return round($hitung_prediksi, 2);
}
// End Function
?>

<!-- class play -->
<div class="table-responsive mt-4 mb-2">
    <h5>Class Probabilitas Play</h5>
    <table class="table table-light table-bordered table-sm">
        <thead class="text-center">
            <tr>
                <th scope="col" class="col-2 col-sm-4">Class</th>
                <th scope="col">Yes</th>
                <th scope="col">No</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Play</td>
                <td><?php echo probabilitas_play('yes') . " %"; ?></td>
                <td><?php echo probabilitas_play('no') . " %"; ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php
// array biar bisa looping cantik, wkwk
$probClass = [
    array(
        array("col" => "outlook", "row" => "sunny",),
        array("col" => "outlook", "row" => "cloudy",),
        array("col" => "outlook", "row" => "rainy",),
    ),
    array(
        array("col" => "temperature", "row" => "hot",),
        array("col" => "temperature", "row" => "mild",),
        array("col" => "temperature", "row" => "cool",),
    ),
    array(
        array("col" => "humidity", "row" => "high",),
        array("col" => "humidity", "row" => "normal",)
    ),
    array(
        array("col" => "windy", "row" => "true",),
        array(
            "col" => "windy", "row" => "false",
        )
    ),
];

$i = 0;
foreach ($probClass as $class) { ?>

    <div class="table-responsive mb-2">
        <h5>Class Probabilitas <?php echo $class[0]['col'] ?></h5>
        <table class="table table-light table-bordered table-sm">
            <thead class="text-center">
                <tr>
                    <th scope="col" class="col-4"><?php echo $class[0]['col'] ?></th>
                    <th scope="col" class="col-4">Yes</th>
                    <th scope="col" class="col-4">No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $panjang_nilai = count($class);
                // var_dump($class[0]);
                for ($j = 0; $j < $panjang_nilai; $j++) {
                    $col = $class[$j]['col'];
                    $row = $class[$j]['row'];
                    ?>
                    <tr>
                        <td><?php echo $row; ?></td>
                        <td><?php echo vlookup($col, $row, 'yes') . " %" ?></td>
                        <td><?php echo vlookup($col, $row, 'no') . " %" ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php $i++;
} ?>

<!-- batas -->
<div class="col-12 my-4" style="border-bottom: 2px solid #8c8a8a;"></div>
<!-- end batas -->

<div id="tabelPrediksi" class="table-responsive mb-2">
    <h3 class="text-center">Tabel Prediksi</h3>
    <table class="table table-light table-bordered table-sm">
        <thead class="text-center">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nilai 'Yes'</th>
                <th scope="col">Nilai 'No'</th>
                <th scope="col">Prediski</th>
                <th scope="col">Testing</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // array untuk hitung keakuratan Prediksi
            $arrayYes = array();
            $arrayNo = array();
            $arrayNothing = array();

            // probabilitas label 
            $play_yes = $_SESSION['play_yes'];
            $play_no = $_SESSION['play_no'];

            // probabilitas lain
            $select_test = mysqli_query($koneksi, "SELECT * FROM tb_testing");
            $i = 1;
            foreach ($select_test as $test) {
                $outlook = $test['outlook'];
                $temperature = $test['temperature'];
                $humidity = $test['humidity'];
                $windy = $test['windy'];
                $play = $test['play'];

                // yes
                $sessionOutlook_yes = $_SESSION["$outlook" . "_" . "yes"];
                $sessionTemperature_yes = $_SESSION["$temperature" . "_" . "yes"];
                $sessionHumidity_yes = $_SESSION["$humidity" . "_" . "yes"];
                $sessionWindy_yes = $_SESSION["$windy" . "_" . "yes"];
                // no
                $sessionOutlook_no = $_SESSION["$outlook" . "_" . "no"];
                $sessionTemperature_no = $_SESSION["$temperature" . "_" . "no"];
                $sessionHumidity_no = $_SESSION["$humidity" . "_" . "no"];
                $sessionWindy_no = $_SESSION["$windy" . "_" . "no"];

                // prediksi YES
                $prediksi_yes = prediksi($sessionOutlook_yes, $sessionTemperature_yes, $sessionHumidity_yes, $sessionWindy_yes, $play_yes);
                // prediksi NO
                $prediksi_no = prediksi($sessionOutlook_no, $sessionTemperature_no, $sessionHumidity_no, $sessionWindy_no, $play_no);

                // prediksi
                $label_prediksi = ($prediksi_yes > $prediksi_no) ? "yes" : "no";
                ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo  "$prediksi_yes %"; ?></td>
                    <td><?php echo "$prediksi_no %"; ?></td>
                    <?php
                    $color_test = ($play == "yes") ? "#bcf8c0" : "#fec0c1";
                    $color_prediksi = ($label_prediksi == "yes") ? "#bcf8c0" : "#fec0c1";
                    ?>
                    <td style="background-color: <?php echo $color_prediksi ?> !important;"><?php echo $label_prediksi ?></td>
                    <td style="background-color: <?php echo $color_test ?> !important;"><?php echo $play; ?></td>
                </tr>
                <?php
                // kondisi push nilai untuk penentuan keakuratan prediksi
                if ($label_prediksi == $play) {
                    if ($label_prediksi == "yes") {
                        array_push($arrayYes, $label_prediksi);
                    } elseif ($label_prediksi == "no") {
                        array_push($arrayNo, $label_prediksi);
                    }
                } else {
                    array_push($arrayNothing, $label_prediksi);
                }
            } ?>
        </tbody>
    </table>
</div>

<div class="table-responsive mb-2 d-flex justify-content-center">
    <?php
    $predYes = count($arrayYes);
    $predNo = count($arrayNo);
    $predNothing = count($arrayNothing);
    $akurasi = (($predYes + $predNo) / ($predYes + $predNo + $predNothing) * 100);
    if ($akurasi > 75) {
        $color_prediksi = "#bcf8c0";
    }elseif($akurasi > 50 || $akurasi <= 75){
        $color_prediksi = "#fdee99";
    }else{
        $color_prediksi = "#fec0c1";
    }
    ?>
    <div class="akurasi-prediksi text-center px-5 py-2" style="background-color: <?php echo $color_prediksi ?>;">
        <h5>Akurasi Prediksi</h5>
        <span><?php echo "$akurasi %" ?></span>
    </div>
</div>