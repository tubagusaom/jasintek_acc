<form action="?Proses-Edit-Department" method="post" class="form_input">
	<table>
		<tr>
			<td colspan="2"><h1>Edit Department</h1></td>
		</tr>
		<tr>
			<td>Nama Department</td>
			<td>
				<input type="hidden" name="acuan_kode" value="<?php echo $_GET['id']; ?>">
				<input type="text" name="nama" value="<?php echo $_GET['dept']; ?>" placeholder="max 20 character">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" name="simpan" value="Simpan">
			</td>
		</tr>
	</table>
</form>
