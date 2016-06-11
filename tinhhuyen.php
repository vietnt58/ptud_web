<html>
<head>
	<meta charset="utf-8">
	<title>Tỉnh Huyện</title>
</head>
	<?php
		class tinhhuyen{
			public function connect(){
				$host = "localhost";
				$username = "root";
				$password = "";
				$database = "k58t";
				$connect = mysqli_connect($host,$username,$password,$database);
				mysqli_set_charset($connect,"utf8");
				return $connect;
			}
			
			public function view(){
				$sql = "SELECT * FROM tinhhuyen";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}
			
			public function add($id,$matinh,$tentinh){
				$sql = "INSERT INTO tinhhuyen VALUES('NULL','$matinh','$tentinh')";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}
			
			public function search($string){
				$sql = "SELECT * FROM tinhhuyen WHERE matinh LIKE '%$string%' ";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}

			public function getID($id){
				$sql = "SELECT * FROM tinhhuyen WHERE id='$id'";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}

			public function edit($id,$matinh,$tentinh){
				$sql = "UPDATE tinhhuyen SET matinh='$matinh', tentinh='$tentinh' WHERE id='$id'";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}

			public function del($id){
				$sql = "DELETE FROM tinhhuyen WHERE id='$id'";
				$data = mysqli_query($this->connect(),$sql);
				return $data;
			}
		}
	?>

	<div class="view">
		<fieldset style="width: 400px; margin: 0 auto">
		<legend>Bảng mã tỉnh</legend>
		<table cellpadding="5" border="1" style="width: 400px; border-collapse: collapse">
			<tr>
				<td>STT</td>
				<td>Mã tỉnh</td>
				<td>Tên tỉnh</td>
				<td>Quản lý</td>
			</tr>
			<?php
				$view = new tinhhuyen();
				$data = $view->view();
				while($rows = mysqli_fetch_array($data)){
					?>
					<tr>
						<td><?php echo $rows['id']?></td>
						<td><?php echo $rows['matinh']?></td>
						<td><?php echo $rows['tentinh']?></td>
						<td>
							<a href="tinhhuyen.php?act=edit&id=<?php echo $rows['id']?>">Sửa</a>
							<a href="tinhhuyen.php?act=del&id=<?php echo $rows['id']?>">Xóa</a>
						</td>
					</tr>
				<?php
				}
			?>
		</table>
		<?php
			if(isset($_GET['act']) && isset($_GET['id'])){
				$act = $_GET['act'];
				$id = $_GET['id'];
				$manager = new tinhhuyen();
				$data = $manager->getID($id);
				$rows = mysqli_fetch_array($data);
				if($act == "edit"){
					?>
					<form action="" method="post">
						<table cellpadding="5" border="1" style="width: 400px; border-collapse: collapse">
							<tr>
								<td>Mã tỉnh</td>
								<td><input type="text" name="matinh_edit" value="<?php echo $rows['matinh']?>"></td>
							</tr>
							<tr>
								<td>Tên tỉnh</td>
								<td><input type="text" name="tentinh_edit" value="<?php echo $rows['tentinh']?>"></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" name="edit" value="Sửa tỉnh"></td>
							</tr>
						</table>
					</form>
					<?php
						if(isset($_POST['edit'])){
							if(isset($_POST['matinh_edit']) && !empty($_POST['matinh_edit']) && 
								isset($_POST['tentinh_edit']) && !empty($_POST['tentinh_edit'])){
									$matinh_edit = $_POST['matinh_edit'];
									$tentinh_edit = $_POST['tentinh_edit'];
									$edit = new tinhhuyen();
									$data = $edit->edit($id,$matinh_edit,$tentinh_edit);
									header("location:tinhhuyen.php");
							}
							else{
								echo "Bạn chưa nhập đủ thông tin!";
							}
						}
					?>
				<?php
				}
				else if($act == "del"){
					$del = new tinhhuyen();
					$del->del($id);
					header("location:tinhhuyen.php");
				}
			}
		?>
		</fieldset>
	</div>

	
	<div class="add">
		<fieldset style="width: 400px; margin: 0 auto; margin-top: 50px">
		<legend>Thêm tỉnh</legend>
			<form action="" method="post">
				<table cellpadding="5" border="1" style="width: 400px; border-collapse: collapse">
					<tr>
						<td>Mã tỉnh</td>
						<td><input type="text" name="matinh"></td>
					</tr>
					<tr>
						<td>Tên tỉnh</td>
						<td><input type="text" name="tentinh"></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" name="add" value="Thêm tỉnh"></td>
					</tr>
				</table>
			</form>
			<?php
				if(isset($_POST['add'])){
					if(isset($_POST['matinh']) && !empty($_POST['matinh']) && isset($_POST['tentinh']) && !empty($_POST['tentinh'])){
						$matinh = $_POST['matinh'];
						$tentinh = $_POST['tentinh'];
						$add = new tinhhuyen();
						$data = $add->add($id,$matinh,$tentinh);
						header("location:tinhhuyen.php");
					}
				}
			?>
		</fieldset>
	</div>

	<div class="search">
		<fieldset style="width: 400px; margin: 0 auto; margin-top: 50px">
		<legend>Tìm kiếm tỉnh thành</legend>
			<form action="" method="post">
				<table cellpadding="5" border="1" style="width: 400px; border-collapse: collapse">
					<tr>
						<td><input type="text" name="main" placeholder="Nhập mã tỉnh"></td>
						<td><input type="submit" name="search" value="Tìm kiếm"></td>
					</tr>
				</table>
			</form>
			<?php
				if(isset($_POST['search'])){
					if(isset($_POST['main']) && !empty($_POST['main'])){
						$matinh = $_POST['main'];
						$search = new tinhhuyen();
						$data = $search->search($matinh);
						while($rows = mysqli_fetch_array($data)){
							echo "
								<table cellpadding='5' border='1' style='width: 400px; border-collapse: collapse'>
									<tr>
										<td>STT</td>
										<td>Mã tỉnh</td>
										<td>Tên tỉnh</td>
									</tr>
									<tr>
										<td>".$rows['id']."</td>
										<td>".$rows['matinh']."</td>
										<td>".$rows['tentinh']."</td>
									</tr>
								</table>
							";
						}
					}
				}
			?>
		</fieldset>
	</div>
</html>