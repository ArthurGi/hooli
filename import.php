<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Заливка файла</title>
 </head>
 <body>
  <h1>Заливка файла</h1>
  <p><form enctype="multipart/form-data" action="import.php" method="POST">
    <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
    <!-- Название элемента input определяет имя в массиве $_FILES -->
    Отправить этот файл: <input name="userfile" type="file" />
    <input type="submit" value="Send File" />
</form></p>
 <div>
 <!-- Code -->
 <? 
 include('db.php');
 function create_index(){
	 global $mysqli;
 $file = $_FILES["userfile"];
 if(is_uploaded_file($file["tmp_name"]))
   {
    $text = file_get_contents($file["tmp_name"]);
	if ($text!=null){
     move_uploaded_file($file["tmp_name"], "files/".$file["name"]); 
	 $result  = array();
	 $k = 0;
	 $line = 0;
	 $text = str_split($text);
	 for($i=0;$i<count($text);$i++){
		 if($text[$i] == "\n") $line++;
		 if(ctype_alpha($text[$i])) {$result[$k]['word'].= $text[$i];$result[$k]['line'] = $line;$result[$k]['index'][] = $i;}
		 else $k++;
		 }
		 //echo 'ввели: '.$_POST['text'].'<br><br><br>';
		 foreach ($result as $r){
			 $word = $r['word'];
			 $line = $r['line'];
			 $first = $r['index'][0];
			 $last = $r['index'][count($r['index'])-1];
			 $docname = $file["name"];
			$mysqli->query('INSERT INTO main (word, line, first, last, docname) VALUES ("'.$word.'", "'.$line.'", "'.$first.'", "'.$last.'", "'.$docname.'")'); 
		 }
	}

 }
 }
 create_index();
 ?>
  <!-- EndCode -->
 </div>
 </body>
</html>