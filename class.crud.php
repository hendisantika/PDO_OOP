<?php

class crud
{
	private $db;
	
	function __construct($DB_con)
	{
		$this->db = $DB_con;
	}
	
	public function create($Nip,$Name,$TempatLahir,$Ttl,$JenisKelamin,$Agama,$PendNipikan,$Golongan,$BNipang,$Jabatan,$Alamat)
	{
		try
		{
			$stmt = $this->db->prepare("INSERT INTO tabel_pegawai(Nip,Nama,TempatLahir,Ttl,JenisKelamin,Agama,PendNipikan,Golongan, BNipang, Jabatan, Alamat)
			VALUES(:Nip, :Name, :TempatLahir, :Ttl, :JenisKelamin, :Agama, :PendNipikan, :Golongan, :BNipang, :Jabatan, :Alamat)");
			$stmt->bindparam(":Nip",$Nip);
			$stmt->bindparam(":Name",$Name);
			$stmt->bindparam(":TempatLahir",$TempatLahir);
			$stmt->bindparam(":Ttl",$Ttl);
			$stmt->bindparam(":JenisKelamin",$JenisKelamin);
			$stmt->bindparam(":Agama",$Agama);
			$stmt->bindparam(":PendNipikan",$PendNipikan);
			$stmt->bindparam(":Golongan",$Golongan);
			$stmt->bindparam(":BNipang",$BNipang);
			$stmt->bindparam(":Jabatan",$Jabatan);
			$stmt->bindparam(":Alamat",$Alamat);
			$stmt->execute();
			return true;
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
		
	}
	
	public function getNip($Nip)
	{
		$stmt = $this->db->prepare("SELECT * FROM tabel_pegawai WHERE Nip=:Nip");
		$stmt->execute(array(":Nip"=>$Nip));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}
	
	public function update($Nip,$Name,$TempatLahir,$Ttl,$JenisKelamin,$Agama,$PendNipikan,$Golongan,$BNipang,$Jabatan,$Alamat)
	{
		try
		{
			$stmt=$this->db->prepare("UPDATE tabel_pegawai SET Nama=:Nama, 
		                                               TempatLahir_Nip=:TempatLahir, 
													   Ttl=:Ttl,
													   JenisKelamin=:JenisKelamin, 
													   Agama=:Agama,
													   PendNipikan=:PendNipikan,
													   Golongan=:Golongan,
													   BNipang=:BNipang,
													   Jabatan=:Jabatan,
													   Alamat=:Alamat
													WHERE Nip=:Nip ");
			$stmt->bindparam(":Name",$Name);
			$stmt->bindparam(":TempatLahir",$TempatLahir);
			$stmt->bindparam(":Ttl",$Ttl);
			$stmt->bindparam(":JenisKelamin",$JenisKelamin);
			$stmt->bindparam(":Agama",$Agama);
			$stmt->bindparam(":PendNipikan",$PendNipikan);
			$stmt->bindparam(":Golongan",$Golongan);
			$stmt->bindparam(":BNipang",$BNipang);
			$stmt->bindparam(":Jabatan",$Jabatan);
			$stmt->bindparam(":Alamat",$Alamat);
			$stmt->bindparam(":Nip",$Nip);
			$stmt->execute();
			
			return true;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}
	
	public function delete($Nip)
	{
		$stmt = $this->db->prepare("DELETE FROM tbl_pegawai WHERE Nip=:Nip");
		$stmt->bindparam(":Nip",$Nip);
		$stmt->execute();
		return true;
	}
	
	/* paging */
	
	public function dataview($query)
	{
		$stmt = $this->db->prepare($query);
		$stmt->execute();
	
		if($stmt->rowCount()>0)
		{
			$no=1;
			while($row=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				?>
                <tr>
				<td><?php print $no; ?></td>
                <td><?php print($row['Nip']); ?></td>
                <td><?php print($row['Nama']); ?></td>
                <td><?php print($row['TempatLahir']); ?></td>
                <td><?php print($row['Ttl']); ?></td>
                <td><?php print($row['JenisKelamin']); ?></td>
                <td><?php print($row['Agama']); ?></td>
				<td><?php print($row['Pendidikan']); ?></td>
				<td><?php print($row['Golongan']); ?></td>
				<td><?php print($row['Bidang']); ?></td>
				<td><?php print($row['Jabatan']); ?></td>
				<td><?php print($row['Alamat']); $no++; ?></td>
				<td align="center">
                <a href="edit-data.php?edit_Nip=<?php print($row['Nip']); ?>"><i class="glyphicon glyphicon-edit"></i></a>
                </td>
                <td align="center">
                <a href="delete.php?delete_Nip=<?php print($row['Nip']); ?>"><i class="glyphicon glyphicon-remove-circle"></i></a>
                </td>
                </tr>
                <?php
			}
		}
		else
		{
			?>
            <tr>
            <td>Nothing here...</td>
            </tr>
            <?php
		}
		
	}
	
	public function paging($query,$records_per_page)
	{
		$starting_position=0;
		if(isset($_GET["page_no"]))
		{
			$starting_position=($_GET["page_no"]-1)*$records_per_page;
		}
		$query2=$query." limit $starting_position,$records_per_page";
		return $query2;
	}
	
	public function paginglink($query,$records_per_page)
	{
		
		$self = $_SERVER['PHP_SELF'];
		
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		
		$total_no_of_records = $stmt->rowCount();
		
		if($total_no_of_records > 0)
		{
			?><ul class="pagination"><?php
			$total_no_of_pages=ceil($total_no_of_records/$records_per_page);
			$current_page=1;
			if(isset($_GET["page_no"]))
			{
				$current_page=$_GET["page_no"];
			}
			if($current_page!=1)
			{
				$previous =$current_page-1;
				echo "<li><a href='".$self."?page_no=1'>First</a></li>";
				echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
			}
			for($i=1;$i<=$total_no_of_pages;$i++)
			{
				if($i==$current_page)
				{
					echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
				}
				else
				{
					echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
				}
			}
			if($current_page!=$total_no_of_pages)
			{
				$next=$current_page+1;
				echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
				echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
			}
			?></ul><?php
		}
	}
	
	/* paging */
	
}
