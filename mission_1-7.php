<html>
<head>
<meta charset="Shift_JIS" />
</head>
</html>

<?php
//読み込むファイル名の指定
$file_name="kadai1-6.txt";
//ファイルを全て配列に入れる
$ret_array=file($file_name);
//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){
	//配列を順番に表示する
	echo($ret_array[$i]."<br />\n");
	}

?>
