<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Hooli</title>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<!--<style>body {background: url(img/gavin.jpg) no-repeat;background-size: 80%;-webkit-background-size: 100%;</style>-->
 </head>
 <body>
 <img src="http://www.multiversedb.com/static/processed_images/hooli-logo.zys1qhkcwur7f9unrfzj.l.png" height="200px" width="400px" style="margin-left:450px;">
  <div class="row" style="margin-left:400px;margin-top:0px;margin-right:100px;">
  <form action="index.php" method="post">
    <div class="input-group">
    <span class="input-group-btn">
    </span>
    <input type="text" name="text" class="form-control" size="70" placeholder="Make world better by searching for...">
	</div>
	<button type="submit" class="btn btn-success"style="margin-left:160px;margin-top:10px;">Find what you really want..</button>
	</div>
	</form>
	<div class="row" style="margin-left:400px;margin-top:20px;margin-right:100px;">
 <!-- Code -->
 <? include('db.php');
	if (isset($_POST['text']) && $_POST['text']!=''){
		$text = str_split($_POST['text']);
		$k = 0;
//распознаем строку дедовским методом		
			for($i=0;$i<count($text);$i++){
				if(ctype_alpha($text[$i])) $result[$k].= $text[$i];
				else $k++;
			 }	
//начинаем hooli-поиск, держим кулачки, надеемся верим ждем, хотим 5			 
			foreach ($result as $word){
				$query = $mysqli->query("SELECT*FROM main WHERE word ='".$word."'");
				while ($row = mysqli_fetch_array($query)){
					$search_result[$word][]  = $row;
					$arrAll[]= $row;
					$search_result[$word]['docs'][] = $row['docname'];
					$search_result[$word]['docs'] = array_unique($search_result[$word]['docs']);
				}
			}
		if ($search_result!=null){
			foreach ($search_result as $value){
				$arrResult[] = $value['docs'];
				if(count($arrResult)<2) $arrResult = $value['docs'];
				else $arrResult = array_intersect($arrResult,$value['docs']);
				}
			foreach ($arrResult as $doc) {
				foreach($arrAll as $one){
					if($doc==$one['docname']) $hooli[$one['docname']][] = $one;	
				}
			}
 ?>
 <?foreach ($hooli as $k=>$hoo){?>
<div class="jumbotron" style="padding-bottom:5px;padding-top:5px;width:550px">
  <h3><a href="#"><?=$k;?></a></h3>
  <?$doc_text=file_get_contents('files/'.$k);
  foreach($hoo as $h){
  $doc_text = str_replace($h['word'],'<b>'.$h['word'].'</b>',$doc_text);
   }?>
   <p><?=$doc_text;?></p>
</div>
 <?}
}
else if($_POST['text']!='') echo '<h3>Sorry dude, nothing found  ¯\_(ツ)_/¯ </h3>';
	}?>
  <!-- EndCode -->
  </div>
 </body>
</html>