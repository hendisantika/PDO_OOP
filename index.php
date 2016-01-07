<?php
include_once 'dbconfig.php';
?>
<?php include_once 'header.php'; ?>

<div class="clearfix"></div>

<div class="container">
<a href="add-data.php" class="btn btn-large btn-info"><i class="glyphicon glyphicon-plus"></i> &nbsp; Add Records</a>
</div>

<div class="clearfix"></div><br />

<div class="container">
	 <table class='table table-bordered table-responsive'>
     <tr>
	 <th>#</th>
     <th>NIP</th>
     <th>Nama Pegawai</th>
     <th>Tempat Lahir</th>
     <th>Tanggal</th>
     <th>Jenis Kelamin</th>
     <th>Agama</th>
	 <th>Pendidikan</th>
	 <th>Golongan</th>
	 <th>Bidang</th>
	 <th>Bagian</th>
	 <th>Alamat</th>
	 <th colspan="2" align="center">Actions</th>
     </tr>
     <?php
		$query = "SELECT * FROM tabel_pegawai";       
		$records_per_page=5;
		$newquery = $crud->paging($query,$records_per_page);
		$crud->dataview($newquery);
	 ?>
    <tr>
        <td colspan="13" align="center">
 			<div class="pagination-wrap">
            <?php $crud->paginglink($query,$records_per_page); ?>
        	</div>
        </td>
    </tr>
 
</table>
   
       
</div>

<?php include_once 'footer.php'; ?>