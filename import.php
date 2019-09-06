<?php
require_once('application/libraries/PHPExcel/Classes/PHPExcel.php');
$servername = "localhost";
$username = "asistencia";
$password = "asistencia..";
$dbname = "EnerSpain";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error);
} 
 
$file = $_FILES["file"]["name"];
if(!is_dir("Imports/"))
	mkdir("Imports/", 7777);

$directorio="Imports/";
$tipo_archivo="xls";
$fecha= date('Y-m-d_H:i:s');
$nombre_archivo= $fecha.'.importe.'.$tipo_archivo;
$subir_archivo=$directorio.$file;



if(move_uploaded_file($_FILES["file"]["tmp_name"], $subir_archivo))
{
	
	$insert_sql = "INSERT INTO T_Banco(CodEur,DesBan) VALUES ('0ea2352','$subir_archivo')";
		mysqli_query($conn, $insert_sql) or die("database error: ". mysqli_error($conn));
		echo $subir_archivo;
	/*$archivo = $file;
	$inputFileType = PHPExcel_IOFactory::identify($archivo);
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	$objPHPExcel = $objReader->load($archivo);
	$sheet = $objPHPExcel->getSheet(0); 
	$highestRow = $sheet->getHighestRow(); 
	$highestColumn = $sheet->getHighestColumn();*/
	/*$insert_sql = "INSERT INTO T_Banco(CodEur,DesBan) VALUES ('0ea2352','$archivo')";
		mysqli_query($conn, $insert_sql) or die("database error: ". mysqli_error($conn));*/
	/*for ($row = 2; $row <= $highestRow; $row++)
	{
		$CodBan=$sheet->getCell("A".$row)->getValue();
		$CodEur=$sheet->getCell("B".$row)->getValue();
		$DesBan=$sheet->getCell("C".$row)->getValue();					   
		$insert_sql = "INSERT INTO T_Banco(CodBan,CodEur,DesBan) VALUES ('".$CodBan."','".$CodEur."','".$DesBan."')";
		mysqli_query($conn, $insert_sql) or die("database error: ". mysqli_error($conn));
		/*$sql = "INSERT INTO T_Banco (CodBan,CodEur,DesBan) VALUES ('$CodBan','$CodEur','$DesBan')";
		if ($conn->query($sql) === TRUE) 
		{
			echo 'Se Guardo';
		}
		else
		{
			echo 'No se Importo';
		}
	}*/
}
else
{
	echo 'Error al mover el archivo';
}


