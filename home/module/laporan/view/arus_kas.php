<script language="JavaScript" type="text/javascript">
    function checkform ( form )
    {
	    if (form.ftahun.value == "") {
            alert( "Pilih Tahun.!!" );
            form.ftahun.focus();
            return false ;
        }
        return true ;
    }
</script>

<style>
	.export-excel {
		background-color: #1d6d43;
		color: #fff;
		font-size: 13px;
		height: 27px;
		border: 1px solid #144e30;
		margin-right: 5px;
		border-radius: 4px;
		float: right;
		cursor: pointer;
	}
</style>

<form class="" action="" method="post" onsubmit="return checkform(this);">
<table>
	<tr>
		<td colspan="9"><h1>Arus Kas</h1></td>
	</tr>

	<tr>
		<td colspan="3">
			<?php
                // include 'model/modul/casedate.php';

                if (isset($_POST['pencarian'])) {
                    $tahun_1=$_POST['ftahun'];
                    $tahun_2=$tahun_1-1;

                    $Set_Last_Date_1=date("t - F - Y",strtotime("31-12-$tahun_1"));
                    $Set_Last_Date_Num_1=date("Y-m-t",strtotime("31-12-$tahun_1"));

                    $Set_Last_Date_2=date("t - F - Y",strtotime("31-12-$tahun_2"));
                    $Set_Last_Date_Num_2=date("Y-m-t",strtotime("31-12-$tahun_2"));

                    // REVISI PERUBAHAN
                    // $acuansaldo="AND efv_trans<'$ftahun-$fbulan-31'";
                    $acuansaldo_1="AND efv_trans<='$Set_Last_Date_Num_1'";
                    $acuansaldo_2="AND efv_trans<='$Set_Last_Date_Num_2'";

                    $acuantanggal_1="AND CONCAT(YEAR(efv_trans)) = $tahun_1";
                    $acuantanggal_2="AND CONCAT(YEAR(efv_trans)) = $tahun_2";
                    

                    // $aba=bulan(date($fbulan));
                    // .date("t - m - y", strtotime(1-$fbulan-$ftahun))
                            echo "Laporan Arus Kas <b>$tahun_1 - $tahun_2</b>";
                }else {
                    $acuansaldo_1='';
                    $acuansaldo_2='';
                    echo "<b>Pilih Tahun :</b>";
                }
			?>
		</td>

		<td colspan="6">
			<?php if (isset($_POST['pencarian'])) { ?>

                <a onclick="return confirm('EXPORT Arus Kas ?')"
					href="module/laporan/view/export_arus_kas.php?Export-Arus-Kas&&tahun=<?php echo $tahun_1 ?>">
					<button type="button" class="export-excel" name="export">
                        Export <i class="fa fa-file-excel-o"></i>
                    </button>
				</a>

                <a href="module/laporan/view/cetak-arus-kas.php?tahun=<?php echo $tahun_1 ?>" target="_blank">
                    <input type="button" name="cetak" value="Cetak">
                </a>

                <a href="?Arus-Kas&&header=Laporan">
                    <input type="button" class="bback" name="back" value="Kembali">
                </a>

			<?php }else { ?>

				<button type="submit" name="pencarian" class="cari">
					<i class="fa fa-search"></i>
				</button>

                <select class="acount" name="ftahun">
                    <option value="" style="color:darkblue; font-weight:700">Tahun</option>
                        <?php
                            $ft=thn_awal();
                            while ($ft<=thn_akhir()) {
                                echo"<option value='$ft'> $ft </option>";
                                $ft=$ft+1;
                            }
                        ?>
                </select>

            <?php } ?>
		</td>
	</tr>
</table>
</form>


<?php if (isset($_POST['pencarian'])) { ?>

    <table>
        <tr>
            <td align="left" width="30%">
                LAPORAN ARUS KAS (LANGSUNG) <br>
                Untuk Tahun-tahun yang Berakhir <br>
                Pada Tanggal 31 Desember <?=$tahun_1?> dan <?=$tahun_2?>
            </td>
            <th align="center"><?=$tahun_1?></th>
            <th align="center"><?=$tahun_2?></th>
            <td align="right" width="30%">
                STATEMENTS OF CASH FLOWS (DIRECT) <br>
                For the Years Ended <br>
                December 31, <?=$tahun_1?> and <?=$tahun_2?>
            </td>
        </tr>
    </table>

    <table style="margin-top:15px">
        <tr>
            <td colspan="2" align="left" width="50%" style="font-weight:bold;">ARUS KAS DARI AKTIVITAS OPERASI</td>
            <td colspan="2" align="right" width="50%" style="font-weight:bold;">CASH FLOWS FROM OPERATING ACTIVITIES</td>
        </tr>
            <!-- start ARUS KAS DARI AKTIVITAS OPERASI -->
            <?php
                $tak_1=0;

                $sqlreport_1  	="SELECT `kd_report`, `desc_report` FROM `report` WHERE kd_report='701' AND stts_report NOT LIKE '3'";
                $queryreport_1	=mysqli_query($koneksi,$sqlreport_1);
                $datareport_1    =mysqli_fetch_array($queryreport_1);

                $sqlgroup_1	  ="SELECT `kd_group`, `kd_acount`, `kd_report` FROM `report_group` WHERE stts_group NOT LIKE '3' AND kd_report = '$datareport_1[0]' ORDER BY id ASC";
                $querygroup_1	=mysqli_query($koneksi,$sqlgroup_1);
                while($datagroup_1=mysqli_fetch_array($querygroup_1))
                {
                    $sqlacountg_1	  ="SELECT `kd_acount`, `desc_acount` FROM `acount` WHERE stts_acount NOT LIKE '3' AND kd_acount = '$datagroup_1[1]'";
                    $queryacountg_1	=mysqli_query($koneksi,$sqlacountg_1);
                    $dataacountg_1   =mysqli_fetch_array($queryacountg_1);

                $sf_1=0;
                $sqlformula_1	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_1[0]'";
                $queryformula_1	=mysqli_query($koneksi,$sqlformula_1);
                while($dataformula_1=mysqli_fetch_array($queryformula_1)){

                    $sqlsumformula_1=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_1,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_1
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_1[0]
                                $acuantanggal_1
                                ";
                    $querysumformula_1	=mysqli_query($koneksi,$sqlsumformula_1);
                    $datasumformula_1  =mysqli_fetch_array($querysumformula_1);

                    if ($dataformula_1[2]=='D') {
                        $totalmutasi_1=$datasumformula_1['DEBIT_1']-$datasumformula_1['KREDIT_1'];
                    }else {
                        $totalmutasi_1=$datasumformula_1['KREDIT_1']-$datasumformula_1['DEBIT_1'];
                    }
                    $sf_1 += $totalmutasi_1;

                }

                $sf_2=0;
                $sqlformula_2	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_1[0]'";
                $queryformula_2	=mysqli_query($koneksi,$sqlformula_2);
                while($dataformula_2=mysqli_fetch_array($queryformula_2)){

                    $sqlsumformula_2=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_2,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_2
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_2[0]
                                $acuantanggal_2
                                ";
                    $querysumformula_2	=mysqli_query($koneksi,$sqlsumformula_2);
                    $datasumformula_2  =mysqli_fetch_array($querysumformula_2);

                    if ($dataformula_2[2]=='D') {
                        $totalmutasi_2=$datasumformula_2['DEBIT_2']-$datasumformula_2['KREDIT_2'];
                    }else {
                        $totalmutasi_2=$datasumformula_2['KREDIT_2']-$datasumformula_1['DEBIT_2'];
                    }
                    $sf_2 += $totalmutasi_2;

                }
            ?>
            

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%"><?=$dataacountg_1[0]?> - <?php echo "$dataacountg_1[1]"; ?></td>
            <td align="right">
                <?php
                    if ($sf_1==0) {
                        echo "-";
                    }else {
                        $aruskas_1=$sf_1;
                        $tak_1 += $aruskas_1;
                        $potonganak_1=substr($aruskas_1,0,1);

                        if ($potonganak_1=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_1,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_1,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right">
                <?php
                    if ($sf_2==0) {
                        echo "-";
                    }else {
                        $aruskas_2=$sf_2;
                        $tak_2 += $aruskas_2;
                        $potonganak_2=substr($aruskas_2,0,1);

                        if ($potonganak_2=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_2,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_2,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="30%"><?=$dataacountg_1[1]?> - <?php echo "$dataacountg_1[0]"; ?></td>
        </tr>

        <?php } ?>

        <!-- batas -->

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Operasi</td>
            <td align="right" style="font-weight:bold;">
                <?php
                    $potongtak_1=substr($tak_1,0,1);
                    if ($tak_1==0) {
                    echo "-";
                    }else {
                    if ($potongtak_1=="-") {
                        Echo "<font style=color:red>"; echo number_format($tak_1,0,',','.'); Echo "</font>";
                    }else {
                        echo number_format($tak_1,0,',','.');
                    }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">
            <?php
                    $potongtak_2=substr($tak_2,0,1);
                    if ($tak_2==0) {
                    echo "-";
                    }else {
                    if ($potongtak_2=="-") {
                        Echo "<font style=color:red>"; echo number_format($tak_2,0,',','.'); Echo "</font>";
                    }else {
                        echo number_format($tak_2,0,',','.');
                    }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">Total Net Cash Flow from Operating Activities</td>
        </tr>

        <!-- end ARUS KAS DARI AKTIVITAS OPERASI -->
    </table>




    <table style="margin-top:20px">
        <!-- start ARUS KAS DARI AKTIVITAS INVESTASI -->
        <tr>
            <td colspan="2" align="left" width="50%" style="font-weight:bold;">ARUS KAS DARI AKTIVITAS INVESTASI</td>
            <td colspan="2" align="right" width="50%" style="font-weight:bold;">CASH FLOWS FROM INVESTING ACTIVITIES</td>
        </tr>

        <?php
                $tak_3=0;

                $sqlreport_3  	="SELECT `kd_report`, `desc_report` FROM `report` WHERE kd_report='702' AND stts_report NOT LIKE '3'";
                $queryreport_3	=mysqli_query($koneksi,$sqlreport_3);
                $datareport_3    =mysqli_fetch_array($queryreport_3);

                $sqlgroup_3	  ="SELECT `kd_group`, `kd_acount`, `kd_report` FROM `report_group` WHERE stts_group NOT LIKE '3' AND kd_report = '$datareport_3[0]' ORDER BY id ASC";
                $querygroup_3	=mysqli_query($koneksi,$sqlgroup_3);
                while($datagroup_3=mysqli_fetch_array($querygroup_3))
                {
                    $sqlacountg_3	  ="SELECT `kd_acount`, `desc_acount` FROM `acount` WHERE stts_acount NOT LIKE '3' AND kd_acount = '$datagroup_3[1]'";
                    $queryacountg_3	=mysqli_query($koneksi,$sqlacountg_3);
                    $dataacountg_3   =mysqli_fetch_array($queryacountg_3);

                $sf_3=0;
                $sqlformula_3	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_3[0]'";
                $queryformula_3	=mysqli_query($koneksi,$sqlformula_3);
                while($dataformula_3=mysqli_fetch_array($queryformula_3)){

                    $sqlsumformula_3=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_3,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_3
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_3[0]
                                $acuantanggal_1
                                ";
                    $querysumformula_3	=mysqli_query($koneksi,$sqlsumformula_3);
                    $datasumformula_3  =mysqli_fetch_array($querysumformula_3);

                    if ($dataformula_3[2]=='D') {
                        $totalmutasi_3=$datasumformula_3['DEBIT_3']-$datasumformula_3['KREDIT_3'];
                    }else {
                        $totalmutasi_3=$datasumformula_3['KREDIT_3']-$datasumformula_3['DEBIT_3'];
                    }
                    $sf_3 += $totalmutasi_3;

                }

                $sf_4=0;
                $sqlformula_4	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_3[0]'";
                $queryformula_4	=mysqli_query($koneksi,$sqlformula_4);
                while($dataformula_4=mysqli_fetch_array($queryformula_4)){

                    $sqlsumformula_4=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_4,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_4
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_4[0]
                                $acuantanggal_2
                                ";
                    $querysumformula_4	=mysqli_query($koneksi,$sqlsumformula_4);
                    $datasumformula_4  =mysqli_fetch_array($querysumformula_4);

                    if ($dataformula_4[2]=='D') {
                        $totalmutasi_4=$datasumformula_4['DEBIT_4']-$datasumformula_4['KREDIT_4'];
                    }else {
                        $totalmutasi_4=$datasumformula_4['KREDIT_4']-$datasumformula_3['DEBIT_4'];
                    }
                    $sf_4 += $totalmutasi_4;

                }
            ?>
            

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%"><?php echo "$dataacountg_3[0]"; ?> - <?php echo "$dataacountg_3[1]"; ?></td>
            <td align="right">
                <?php
                    if ($sf_3==0) {
                        echo "-";
                    }else {
                        $aruskas_3=$sf_3;
                        $tak_3 += $aruskas_3;
                        $potonganak_3=substr($aruskas_3,0,1);

                        if ($potonganak_3=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_3,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_3,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right">
                <?php
                    if ($sf_4==0) {
                        echo "-";
                    }else {
                        $aruskas_4=$sf_4;
                        $tak_4 += $aruskas_4;
                        $potonganak_4=substr($aruskas_4,0,1);

                        if ($potonganak_4=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_4,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_4,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="30%"><?php echo "$dataacountg_3[1]"; ?> - <?php echo "$dataacountg_3[0]"; ?></td>
        </tr>

        <?php } ?>

        <!-- batas -->

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Investasi</td>
            <td align="right" style="font-weight:bold;">
                <?php
                    $potongtak_3=substr($tak_3,0,1);
                    if ($tak_3==0) {
                    echo "-";
                    }else {
                    if ($potongtak_3=="-") {
                        Echo "<font style=color:red>"; echo number_format($tak_3,0,',','.'); Echo "</font>";
                    }else {
                        echo number_format($tak_3,0,',','.');
                    }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">
            <?php
                    $potongtak_4=substr($tak_4,0,1);
                    if ($tak_4==0) {
                    echo "-";
                    }else {
                    if ($potongtak_4=="-") {
                        Echo "<font style=color:red>"; echo number_format($tak_4,0,',','.'); Echo "</font>";
                    }else {
                        echo number_format($tak_4,0,',','.');
                    }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">Total Net Cash Flow from Investing Activities</td>
        </tr>
        <!-- end ARUS KAS DARI AKTIVITAS INVESTASI -->
    </table>

        





    <table style="margin-top:20px">
        <!-- start ARUS KAS DARI AKTIVITAS PENDANAAN -->
        <tr>
            <td colspan="2" align="left" width="50%" style="font-weight:bold;">ARUS KAS DARI AKTIVITAS PENDANAAN</td>
            <td colspan="2" align="right" width="50%" style="font-weight:bold;">CASH FLOWS FROM FINANCING ACTIVITIES</td>
        </tr>

        <?php
                $tak_5=0;

                $sqlreport_5  	="SELECT `kd_report`, `desc_report` FROM `report` WHERE kd_report='703' AND stts_report NOT LIKE '3'";
                $queryreport_5	=mysqli_query($koneksi,$sqlreport_5);
                $datareport_5    =mysqli_fetch_array($queryreport_5);

                $sqlgroup_5	  ="SELECT `kd_group`, `kd_acount`, `kd_report` FROM `report_group` WHERE stts_group NOT LIKE '3' AND kd_report = '$datareport_5[0]' ORDER BY id ASC";
                $querygroup_5	=mysqli_query($koneksi,$sqlgroup_5);
                while($datagroup_5=mysqli_fetch_array($querygroup_5))
                {
                    $sqlacountg_5	  ="SELECT `kd_acount`, `desc_acount` FROM `acount` WHERE stts_acount NOT LIKE '3' AND kd_acount = '$datagroup_5[1]'";
                    $queryacountg_5	=mysqli_query($koneksi,$sqlacountg_5);
                    $dataacountg_5   =mysqli_fetch_array($queryacountg_5);

                $sf_5=0;
                $sqlformula_5	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_5[0]'";
                $queryformula_5	=mysqli_query($koneksi,$sqlformula_5);
                while($dataformula_5=mysqli_fetch_array($queryformula_5)){

                    $sqlsumformula_5=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_5,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_5
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_5[0]
                                $acuantanggal_1
                                ";
                    $querysumformula_5	=mysqli_query($koneksi,$sqlsumformula_5);
                    $datasumformula_5  =mysqli_fetch_array($querysumformula_5);

                    if ($dataformula_5[2]=='D') {
                        $totalmutasi_5=$datasumformula_5['DEBIT_5']-$datasumformula_5['KREDIT_5'];
                    }else {
                        $totalmutasi_5=$datasumformula_5['KREDIT_5']-$datasumformula_5['DEBIT_5'];
                    }
                    $sf_5 += $totalmutasi_5;

                }

                $sf_6=0;
                $sqlformula_6	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_5[0]'";
                $queryformula_6	=mysqli_query($koneksi,$sqlformula_6);
                while($dataformula_6=mysqli_fetch_array($queryformula_6)){

                    $sqlsumformula_6=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_6,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_6
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_6[0]
                                $acuantanggal_2
                                ";
                    $querysumformula_6	=mysqli_query($koneksi,$sqlsumformula_6);
                    $datasumformula_6  =mysqli_fetch_array($querysumformula_6);

                    if ($dataformula_6[2]=='D') {
                        $totalmutasi_6=$datasumformula_6['DEBIT_6']-$datasumformula_6['KREDIT_6'];
                    }else {
                        $totalmutasi_6=$datasumformula_6['KREDIT_6']-$datasumformula_5['DEBIT_6'];
                    }
                    $sf_6 += $totalmutasi_6;

                }
            ?>
            

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%"><?php echo "$dataacountg_5[0]"; ?> - <?php echo "$dataacountg_5[1]"; ?></td>
            <td align="right">
                <?php
                    if ($sf_5==0) {
                        echo "-";
                    }else {
                        $aruskas_5=$sf_5;
                        $tak_5 += $aruskas_5;
                        $potonganak_5=substr($aruskas_5,0,1);

                        if ($potonganak_5=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_5,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_5,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right">
                <?php
                    if ($sf_6==0) {
                        echo "-";
                    }else {
                        $aruskas_6=$sf_6;
                        $tak_6 += $aruskas_6;
                        $potonganak_6=substr($aruskas_6,0,1);

                        if ($potonganak_6=="-") {
                            Echo "<font style=color:red>"; echo number_format($aruskas_6,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($aruskas_6,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="30%"><?php echo "$dataacountg_5[1]"; ?> - <?php echo "$dataacountg_5[0]"; ?></td>
        </tr>

        <?php } ?>

        <!-- batas -->

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Pendanaan</td>
            <td align="right" style="font-weight:bold;">
                <?php
                    $potongtak_5=substr($tak_5,0,1);
                    if ($tak_5==0) {
                        echo "-";
                    }else {
                        if ($potongtak_5=="-") {
                            Echo "<font style=color:red>"; echo number_format($tak_5,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($tak_5,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">
                <?php
                    $potongtak_6=substr($tak_6,0,1);
                    if ($tak_6==0) {
                        echo "-";
                    }else {
                        if ($potongtak_6=="-") {
                            Echo "<font style=color:red>"; echo number_format($tak_6,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($tak_6,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" style="font-weight:bold;">Total Net Cash Flow of Financing Activities</td>
        </tr>
        <!-- end ARUS KAS DARI AKTIVITAS PENDANAAN -->
    </table>

    <!-- batas -->




    <table style="margin-top:20px">
        <!-- start Kenaikan / Penurunan Kas Bersih -->
        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Kenaikan / Penurunan Kas Bersih</td>
            <td align="right" width="20%" style="font-weight:bold;">
                <?php
                    $potongkpkb_1=0;
                    $kpkb_1 = $tak_1+$tak_3+$tak_5;
                    $potongkpkb_1=substr($kpkb_1,0,1);
                    if ($kpkb_1==0) {
                        echo "-";
                    }else {
                        if ($potongkpkb_1=="-") {
                            Echo "<font style=color:red>"; echo number_format($kpkb_1,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($kpkb_1,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="20%" style="font-weight:bold;">
                <?php
                    $potongkpkb_2=0;
                    $kpkb_2 = $tak_2+$tak_4+$tak_6;
                    $potongkpkb_2=substr($kpkb_2,0,1);
                    if ($kpkb_2==0) {
                        echo "-";
                    }else {
                        if ($potongkpkb_2=="-") {
                            Echo "<font style=color:red>"; echo number_format($kpkb_2,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($kpkb_2,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="30%" style="font-weight:bold;">Increase / Decrease in Net Cash</td>
        </tr>
        <!-- end Kenaikan / Penurunan Kas Bersih -->
    </table>




    <table style="margin-top:20px">
        <!-- start Saldo Kas Awal -->

        <?php
                $ska_7=0;
                $ska_8=0;
                $tak_7=0;

                $sqlreport_7  	="SELECT `kd_report`, `desc_report` FROM `report` WHERE kd_report='601' AND stts_report NOT LIKE '3'";
                $queryreport_7	=mysqli_query($koneksi,$sqlreport_7);
                $datareport_7    =mysqli_fetch_array($queryreport_7);

                $sqlgroup_7	  ="SELECT `kd_group`, `kd_acount`, `kd_report` FROM `report_group` WHERE stts_group NOT LIKE '3' AND kd_report = '$datareport_7[0]' ORDER BY id ASC";
                $querygroup_7	=mysqli_query($koneksi,$sqlgroup_7);
                while($datagroup_7=mysqli_fetch_array($querygroup_7))
                {
                    $sqlacountg_7	  ="SELECT `desc_acount` FROM `acount` WHERE stts_acount NOT LIKE '3' AND kd_acount = '$datagroup_7[1]'";
                    $queryacountg_7	=mysqli_query($koneksi,$sqlacountg_7);
                    $dataacountg_7   =mysqli_fetch_array($queryacountg_7);
                    
                $sf_7=0;
                $sqlformula_7	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_7[0]'";
                $queryformula_7	=mysqli_query($koneksi,$sqlformula_7);
                while($dataformula_7=mysqli_fetch_array($queryformula_7)){

                    $sqlsumformula_7=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_7,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_7
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_7[0]
                                $acuantanggal_1
                                ";
                    $querysumformula_7	=mysqli_query($koneksi,$sqlsumformula_7);
                    $datasumformula_7  =mysqli_fetch_array($querysumformula_7);

                    if ($dataformula_7[2]=='D') {
                        $totalmutasi_7=$datasumformula_7['DEBIT_7']-$datasumformula_7['KREDIT_7'];
                    }else {
                        $totalmutasi_7=$datasumformula_7['KREDIT_7']-$datasumformula_7['DEBIT_7'];
                    }
                    $sf_7 += $totalmutasi_7;

                }

                
                $sf_8=0;
                $sqlformula_8	  ="SELECT `kd_acount`, `kd_group`, `jenis_formula` FROM `report_formula` WHERE `stts_formula` NOT LIKE '3' AND kd_group = '$datagroup_7[0]'";
                $queryformula_8	=mysqli_query($koneksi,$sqlformula_8);
                while($dataformula_8=mysqli_fetch_array($queryformula_8)){

                    $sqlsumformula_8=
                                "SELECT
                                SUM(IF(`jenis_trans` = 'D',`saldo_trans`,0)) AS DEBIT_8,
                                SUM(IF(`jenis_trans` = 'K',`saldo_trans`,0)) AS KREDIT_8
                                FROM trans WHERE
                                stts_trans NOT LIKE '3' AND
                                kd_acount = $dataformula_8[0]
                                $acuantanggal_2
                                ";
                    $querysumformula_8	=mysqli_query($koneksi,$sqlsumformula_8);
                    $datasumformula_8  =mysqli_fetch_array($querysumformula_8);

                    if ($dataformula_8[2]=='D') {
                        $totalmutasi_8=$datasumformula_8['DEBIT_8']-$datasumformula_8['KREDIT_8'];
                    }else {
                        $totalmutasi_8=$datasumformula_8['KREDIT_8']-$datasumformula_7['DEBIT_8'];
                    }
                    $sf_8 += $totalmutasi_8;

                    $ska_7 += $sf_7;
                    $ska_8 += $sf_8;

                }
            }
        ?>

        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Saldo Kas Awal</td>
            <td align="right" width="20%" style="font-weight:bold;">
                <?php
                    if ($ska_7==0) {
                        echo "-";
                    }else {
                        $aruskas_7=$ska_7;
                        $tak_7 += $aruskas_7;
                        $potonganak_7=substr($ska_7,0,1);

                        if ($potonganak_7=="-") {
                            Echo "<font style=color:red>"; echo number_format($tak_7,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($tak_7,0,',','.');
                        }
                    }
                ?>
            </td>

            <td align="right" width="20%" style="font-weight:bold;">
            <?php
                    if ($ska_8==0) {
                        echo "-";
                    }else {
                        $aruskas_8=$ska_8;
                        $tak_8 += $aruskas_8;
                        $potonganak_8=substr($ska_8,0,1);

                        if ($potonganak_8=="-") {
                            Echo "<font style=color:red>"; echo number_format($tak_8,0,',','.'); Echo "</font>";
                        }else {
                            echo number_format($tak_8,0,',','.');
                        }
                    }
                ?>
            </td>
            <td align="right" width="30%" style="font-weight:bold;">Beginning Cash Balance</td>
        </tr>
        <!-- end Saldo Kas Awal -->
    </table>


    <!-- <table style="margin-top:20px">
        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Saldo Kas Akhir</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" width="30%" style="font-weight:bold;">Final Cash Balance</td>
        </tr>
    </table> -->

<?php }else{echo "";} ?>
