<?php
  session_start();
  include '../../../model/modul/casedate.php';
  include "../../../model/config/master_koneksi.php";
  $tahun_1=$_GET['tahun'];
  $tahun_2=$tahun_1-1;

  $Set_Last_Date_1=date("t - F - Y",strtotime("31-12-$tahun_1"));
  $Set_Last_Date_Num_1=date("Y-m-t",strtotime("31-12-$tahun_1"));

  $Set_Last_Date_2=date("t - F - Y",strtotime("31-12-$tahun_2"));
  $Set_Last_Date_Num_2=date("Y-m-t",strtotime("31-12-$tahun_2"));

  $acuansaldo_1="AND efv_trans<='$Set_Last_Date_Num_1'";
  $acuansaldo_2="AND efv_trans<='$Set_Last_Date_Num_2'";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Arus Kas <?php echo "$tahun_1" . " - " . "$tahun_2"; ?></title>
    <link href="../../../images/b_print.png" rel="icon" type="image/png" />
</head>

<body>
    Arus Kas <?="$tahun_1" . " & " . "$tahun_2"?>
</body>

</html>