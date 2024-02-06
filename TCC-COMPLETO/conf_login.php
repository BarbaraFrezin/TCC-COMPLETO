<?php
	include('config.php');
	$sql = "SELECT * FROM `usuarios`";
	if ($result = mysqli_query($con, $sql)) {
		$row_cnt = mysqli_num_rows($result);
		if ($row_cnt > 0){
			while ($linha = mysqli_fetch_array($result)) {
				#$linha = mysqli_fetch_array($result);
				echo $linha["NOME"]."<br>";
			}
		}
	    mysqli_free_result($result);
	}
?>
