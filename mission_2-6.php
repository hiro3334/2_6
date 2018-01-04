<?php

//編集データの指定

if(($_POST['編集番号']<>"") and ($_POST['pasuhen']<>"") and (isset($_POST['編集番号指定ボタン']))){
$filename="kadai2-6.txt";
//ファイルを全て配列に入れる
$ret_array=file($filename);
//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){
	//配列を順番に表示する
	$arr=explode("<>",$ret_array[$i]);
	//入力された数字と配列の頭の数字が一致するかの確認
	if($arr[0]==$_POST['編集番号']){
$pasuhen=$arr[4];
}
}
if($pasuhen==$_POST['pasuhen']){

//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){
	//配列を順番に表示する
	$arr=explode("<>",$ret_array[$i]);
	//入力された数字と配列の頭の数字が一致するかの確認
	if($arr[0]==$_POST['編集番号']){
session_start();
$_SESSION["suuji"]=$arr[0];
$_SESSION["namae"]=$arr[1];
$_SESSION["komento"]=$arr[2];
$_SESSION["pas"]=$arr[4];
}
}

echo "【編集対象】"."<br/>\n";
echo "$suuji"." ";
echo "名前："."$namae"." ";
echo "コメント："."$komento";


header("location:mission_2-6-2.php");
}else{
echo "パスワードが違います";
}



}


?>

<html>
<head>
<meta charset="Shift_JIS" />
<title>写真ブログ</title>
</head>
<body>
<h1>写真好きが集まるブログ</h1>
<form method="post" action="mission_2-6.php">
<p>
	名前：<input type="text" name="名前" value="<?php echo $namae; ?>"/><br/>
	コメント：<input type="text" name="コメント" value="<?php echo $komento; ?>"/><br/>
	パスワード：<input type="password" name="パスワアド"><br/>
	<input type="submit" name="入力" value="新規入力"><br/>
	削除対象番号：<input type="text" name="削除"/><br/>
	パスワード：<input type="password" name="pasusaku"><br/>
	<input type="submit" name="削除する" value="削除"><br/>
	編集対象番号：<input type="text" name="編集番号"><br/>
	パスワード：<input type="password" name="pasuhen"><br/>
	<input type="submit" name="編集番号指定ボタン" value="編集する番号を指定"><br/>
	<input type="hidden" name="差し替え" value="<?php echo $suuji; ?>"/>
</p>
</form>
</body>
</html>

<?php
$filename='kadai2-6.txt';
$ret_array=file($filename);

//入力フォーム
if(($_POST['名前']<>"") and ($_POST['コメント']<>"") and ($_POST['パスワアド']<>"") and (isset($_POST['入力']))){
//テキストファイルを作成する
$filename='kadai2-6.txt';

	if(is_readable($filename)){
	$lines=file($filename);
	$lastLine=$lines[count($lines)-1];
	$numb=explode("<>", $lastLine);
	$num=$numb[0]+1;
	}else{
		$num=1;
	}

$fp=fopen("kadai2-6.txt","a");
fwrite($fp,$num."<>".$_POST['名前']."<>".$_POST['コメント']."<>".date("Y/m/d")." ".date("H:i:s")."<>".$_POST['パスワアド']."<>"."\n");
fclose($fp);

}elseif((($_POST['名前']<>"") and ($_POST['コメント']<>""))or(($_POST['コメント']<>"") and ($_POST['パスワアド']<>""))or(($_POST['名前']<>"")and($_POST['パスワアド']<>""))or($_POST['名前']<>"")or($_POST['コメント']<>"")or($_POST['パスワアド']<>"")and(isset($_POST['入力']))){
echo "未入力の項目があります"."<br />\n";
}

//削除フォーム
if(($_POST['削除']<>"") and($_POST['pasusaku']<>"") and (isset($_POST['削除する']))){

$filename="kadai2-6.txt";
//ファイルを全て配列に入れる
$ret_array=file($filename);
//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){
	//配列を順番に表示する
	$arr=explode("<>",$ret_array[$i]);
	//入力された数字と配列の頭の数字が一致するかの確認
	if($arr[0]==$_POST['削除']){
$pasusaku=$arr[4];
}
}
if($pasusaku==$_POST['pasusaku']){

//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){
	//配列を順番に表示する
	$arr=explode("<>",$ret_array[$i]);
	if(($arr[0] <> $_POST['削除']) and ($arr[4]<>$_POST['pasusaku'])){
$hensuu[$i]="$arr[0]"."<>"."$arr[1]"."<>"."$arr[2]"."<>"."$arr[3]"."<>"."$arr[4]"."<>"."\n";
}
}


$fp=fopen("kadai2-6.txt","w+");
for($i=0;  $i < count($ret_array);  ++$i){
fwrite($fp,$hensuu[$i]);
}
fclose($fp);

}else{
echo "パスワードが違います"."<br />\n";
}

}

$filename='kadai2-6.txt';
$ret_array=file($filename);

//取得したファイルデータ（配列）を全て表示する
for($i=0;  $i < count($ret_array);  ++$i){

	//配列を順番に表示する
	$arr=explode("<>",$ret_array[$i]);
	echo ("$arr[0]"." "."$arr[1]"." "."$arr[2]"." "."$arr[3]"." "."<br />\n");
	}

?>

