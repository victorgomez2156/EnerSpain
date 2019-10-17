<?php

$file = $_FILES["file"]["name"];

if(!is_dir("documentos/"))
	mkdir("documentos/", 7777);

if($file && move_uploaded_file($_FILES["file"]["tmp_name"], "documentos/".$file))
{
	echo $file;
} 


