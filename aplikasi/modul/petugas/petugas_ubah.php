<?php
if (!defined('nsi')) { exit(); }

$id = $_GET['id'];

$query = "SELECT * FROM `tbl_petugas` WHERE `id` = '".$id."' ";
$row = $db->select_one($query);
if(!$row) {
	set_notif('data_tidak_ada', 1);
	redirect('?m=petugas');
}

$form_error = array();
if(isset($_POST['submit'])) {
	$data_arr = array();
	if(trim($_POST['nama_petugas']) == '') {
		$form_error[] = 'Nama harus diisi';
	}
	if(trim($_POST['jenis_kelamin']) == '') {
		$form_error[] = 'Jenis kelamin harus diisi';
	}
	if(trim($_POST['alamat']) == '') {
		$form_error[] = 'Alamat harus diisi';
	}
	if(trim($_POST['no_telp']) == '') {
		$form_error[] = 'Nomor telepon harus diisi';
	}

	if(empty($form_error)) {
		// update db
		$data = array(
			'nama_petugas' 			=> $_POST['nama_petugas'],
			'jenis_kelamin' 		=> $_POST['jenis_kelamin'],
			'alamat' 				=> $_POST['alamat'],
			'no_telp' 				=> $_POST['no_telp']
			);
		if(trim($_POST['upass']) != '') {
			$data['upass']	= md5($_POST['upass']);
		}

		$where = array('id' => $id);
		$update = $db->ubah('tbl_petugas', $data, $where);
		if($update) {
			set_notif('ubah_ok', 1);
			redirect('?m=petugas');
		} else {
			$form_error[] = 'Tidak dapat disimpan dalam database';
		}
	}
}

$web['judul'] = 'Ubah Data Petugas';
load_script('select2');
view_layout('v_atas.php');

?>

<div class="row">
	<div class="col-md-12">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Ubah Data Petugas</h3>
				<div class="box-tools pull-right">
					<button data-widget ="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->

			<form method="POST">
				<div class="box-body">
					<?php if($form_error) { ?>
					<div id="alert-simpan" class="alert alert-danger alert-dismissable fade in">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						<h4><i class="fa fa-warning"></i> Error, Data tidak dapat disimpan.</h4>
						<?php 
						foreach ($form_error as $val) {
							echo '<p>'.$val.'</p>';
						} 
						?>
					</div>					
					<?php } ?>


					<div class="form-group">
						<label for="nama_petugas">Nama</label>
						<input type="text" placeholder="Masukkan Nama" id="nama_petugas" name="nama_petugas" class="form-control" value="<?php echo $row->nama_petugas; ?>">
					</div>

					<div class="form-group">
						<label>Jenis Kelamin</label>
						<br />
						<select id="jenis_kelamin" name="jenis_kelamin" class="form-control select2" style="width: 100px;">
							<option value="laki-laki" <?php echo $row->jenis_kelamin == 'Laki-Laki' ? 'selected="selected"' : ''; ?>>Laki-Laki</option>
							<option value="perempuan"	 <?php echo $row->jenis_kelamin == 'Perempuan' ? 'selected="selected"' : ''; ?>>Perempuan</option>
						</select>
					</div>

					<div class="form-group">
						<label for="alamat"> Alamat </label>
						<input type="text" placeholder="Masukkan Username" id="alamat" name="alamat" class="form-control" value="<?php echo $row->alamat; ?>">
					</div>

					<div class="form-group">
						<label for="no_telp"> Nomor Telepon </label>
						<input type="text" placeholder="Masukkan Username" id="no_telp" name="no_telp" class="form-control" value="<?php echo $row->no_telp; ?>">
					</div>


				</div><!-- /.box-body -->
				<div class="box-footer">
					<button type="submit" name="submit" class="btn btn-primary btn-sm"> <i class="fa fa-save"></i> <b>Ubah</b> </button>
					<a href="<?php echo site_url('?m=petugas');?>" class="btn btn-warning btn-sm pull-right"> <i class="fa fa-angle-double-left"></i> <b>Kembali</b> </a>
				</div>
			</form>

		</div><!-- /.box -->
	</div>
</div>



<?php view_layout('v_bawah1.php'); ?>

<script type="text/javascript">
	$(function() {
		$('#nama').focus();
		$('.select2').select2();
	});
</script>
<?php
view_layout('v_bawah2.php');