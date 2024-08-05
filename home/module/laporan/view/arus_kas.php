<script language="JavaScript" type="text/javascript">
    function checkform ( form )
    {
			if (form.fbulan.value == "") {
        alert( "Pilih Bulan Akhir.!!" );
        form.fbulan.focus();
        return false ;
      }else if (form.ftahun.value == "") {
        alert( "Pilih Tahun.!!" );
        form.ftahun.focus();
        return false ;
      }
      return true ;
    }
</script>

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
          //
          // $acuansaldo="AND efv_trans<'$ftahun-$fbulan-31'";
          $acuansaldo_1="AND efv_trans<='$Set_Last_Date_1'";
          $acuansaldo_2="AND efv_trans<='$Set_Last_Date_2'";

          $aba=bulan(date($fbulan));
          // .date("t - m - y", strtotime(1-$fbulan-$ftahun))
					echo "Laporan Arus Kas <b>$tahun_1 - $tahun_2</b>";
				}else {
          $acuansaldo='';

				  echo "<b>Pilih Tahun :</b>";
				}
			?>
		</td>

		<td colspan="6">
			<?php if (isset($_POST['pencarian'])) { ?>

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
            while ($ft<=thn_akhir())
            {
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

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%">akun 1</td>
            <td align="right">1 Rp. xxx</td>
            <td align="right">2 Rp. xxx</td>
            <td align="right" width="30%">akun 2</td>
        </tr>

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Operasi</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">Total Net Cash Flow from Operating Activities</td>
        </tr>

        <!-- batas -->
        <!-- <tr bgcolor="whitesmoke"><td colspan="4">&nbsp;</td></tr> -->
        <!-- batas -->
    </table>




    <table style="margin-top:15px">
        <tr>
            <td colspan="2" align="left" width="50%" style="font-weight:bold;">ARUS KAS DARI AKTIVITAS INVESTASI</td>
            <td colspan="2" align="right" width="50%" style="font-weight:bold;">CASH FLOWS FROM INVESTING ACTIVITIES</td>
        </tr>

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%">akun 1</td>
            <td align="right">1 Rp. xxx</td>
            <td align="right">2 Rp. xxx</td>
            <td align="right" width="30%">akun 2</td>
        </tr>

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Investasi</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" style=";font-weight:bold;">Total Net Cash Flow from Investing Activities</td>
        </tr>
    </table>

        





    <table style="margin-top:15px">
        <tr>
            <td colspan="2" align="left" width="50%" style="font-weight:bold;">ARUS KAS DARI AKTIVITAS PENDANAAN</td>
            <td colspan="2" align="right" width="50%" style="font-weight:bold;">CASH FLOWS FROM FINANCING ACTIVITIES</td>
        </tr>

        <tr bgcolor="whitesmoke">
            <td align="left" width="30%">akun 1</td>
            <td align="right">1 Rp. xxx</td>
            <td align="right">2 Rp. xxx</td>
            <td align="right" width="30%">akun 2</td>
        </tr>

        <tr>
            <td align="left" style="font-weight:bold;">Jumlah Arus Kas Bersih Aktivitas Pendanaan</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">Total Net Cash Flow of Financing Activities</td>
        </tr>
    </table>

    <table style="margin-top:15px">
        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Kenaikan / Penurunan Kas Bersih</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" width="30%" style="font-weight:bold;">Increase / Decrease in Net Cash</td>
        </tr>
    </table>

    <table style="margin-top:15px">
        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Saldo Kas Awal</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" width="30%" style="font-weight:bold;">Beginning Cash Balance</td>
        </tr>
    </table>

    <table style="margin-top:15px">
        <tr>
            <td align="left" width="30%" style="font-weight:bold;">Saldo Kas Akhir</td>
            <td align="right" style="font-weight:bold;">1 Rp. xxx</td>
            <td align="right" style="font-weight:bold;">2 Rp. xxx</td>
            <td align="right" width="30%" style="font-weight:bold;">Final Cash Balance</td>
        </tr>
    </table>

<?php }else{echo "";} ?>
