<table>
	<tr>
		<td colspan="5"><h1>Data User Pengurus</h1></td>
	</tr>

	<tr>
		<th>No</th>
		<th>Nama User</th>
		<th>Username</th>
		<th>Hak Akses</th>
		<th align="center">-</th>
	</tr>

	<?php

		$no=1;

		$limit = $this_login->akses_limit($_SESSION['akses']);

		$sql	= mysqli_query($koneksi,"SELECT
				a.id,
				a.kd_user,
				a.pw_user,
				a.akses_user,
				a.stts_user,
				a.c_user,
				a.id_akun,
				a.pw_asli,
				b.kd_user AS id_user,
				b.kd_role AS akses,
				c.keterangan AS namaakses
			FROM user a
			LEFT JOIN t_user_role b ON b.kd_user = a.id
			LEFT JOIN t_role c ON c.id = b.kd_role
			WHERE
				a.stts_user NOT LIKE '3' AND
				a.stts_user NOT LIKE '4' AND
				a.stts_user NOT LIKE '5' AND
				a.stts_user NOT LIKE '6' AND
				b.kd_role NOT LIKE '66'
			ORDER BY b.kd_role ASC $limit
		");

		while($data=mysqli_fetch_array($sql))
		{
			if(fmod($no,2)==1)
			{$warna="ghostwhite";}
			else
			{$warna="whitesmoke";}

			$sqls	  ="SELECT * FROM akun where id=$data[id_akun]";
			$querys	=mysqli_query($koneksi,$sqls);
			$datas	=mysqli_fetch_array($querys);

			if ($data[3]=='default') {
				$warna="#000";
			}
	?>

	<tr class="hover" bgcolor="<?php echo $warna ?>">
		<td align="center"><?php echo $no; ?>.</td>
		<td>
			<?php
				if ($data[3]=='default') {
					echo "Anonimouse";
				}elseif ($data[3]=='superuser') {
					echo "Rumah Produktif";
				}else {
					echo "$datas[2]";
				}
			?>
		</td>
		<td><?php echo "$data[1]"; ?></td>
		<td>
			<?php

				if (isset($data['akses'])) {
					if ($data['namaakses'] == 'Authentic User') {
						echo "Root";
					}else {
						echo $data['namaakses'];
					}
				}else {
					echo "Tidak Ada Akses";
				}

			?>
		</td>
		<td align="center" width="14%">
			<?php if ($data[3]=='default' || $data[3]=='superuser') { ?>
			<font style="color:red; font-weight:700">No Action</font>
			<?php }else{ ?>
			<a href="?Edit-User&&header=<?php echo "User" ?>&&id=<?php echo "$data[0]" ?>&&user=<?php echo "$data[1]" ?>&&pw=<?php echo "$data[7]" ?>&&aks=<?php echo "$data[3]" ?>&&akun=<?php echo "$data[6]" ?>">Edit</a> |
			<a href="?Hapus-User&&id=<?php echo "$data[0]" ?>" onclick="return confirm('apakah anda yakin ?')">Hapus</a> |
			<a href="?Reset-Password&&id=<?php echo "$data[0]" ?>" onclick="return confirm('Password akan direset ?')">Reset</a>
			<?php } ?>
		</td>
	</tr>

	<?php
		$no++;};
	?>

</table>
