<table>
  <tr>
    <td colspan="4"><h1>Data Toolbar</h1></td>
  </tr>

  <tr>
    <th>No</th>
    <th>Toolbar</th>
    <th>Keterangan</th>
    <th align="center">-</th>
  </tr>

  <?php

		$no		  =1;
    // SELECT a.id, a.name,b.id FROM tutorials_inf a
		$sql_role	  =
              "SELECT
                  a.id,
                  a.nama_toolbar,
                  a.keterangan,
                  a.c_toolbar
                FROM t_toolbar a
                -- WHERE a.stts_akses NOT LIKE '3'
                ORDER BY a.id ASC
              ";
		$query_role	=mysqli_query($koneksi,$sql_role);
		while($data_role=mysqli_fetch_array($query_role)){

			if(fmod($no,2)==1)
			{$warna="ghostwhite";}
			else
			{$warna="whitesmoke";}

	?>

  <tr class="hover" bgcolor="<?php echo $warna ?>">
		<td align="center"><?php echo $no; ?>.</td>
		<td><?php echo "$data_role[nama_toolbar]"; ?></td>
		<td>
			<?php
				echo "$data_role[keterangan]";
        // $nmdivisi = str_replace('&', 'and', $data_role['nmdivisi']);
			?>
		</td>

		<td align="center">
			<a href="?Toolbar&&header=<?='Konfigurasi'?>&&id=<?=$data_role['id']?>&&nama=<?=$data_role['nama_toolbar']?>&&ket=<?=$data_role['keterangan']?>&&Toolbars=Addacl&&Toolbar-Edit" >
        <b> Edit <i class="fa fa-edit"></i> </b>
      </a>
		</td>

	</tr>

	<?php
		$no++;};
	?>
</table>
