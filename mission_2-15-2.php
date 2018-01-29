<?php
session_start()
?>

<?php

if(($_POST['名前']<>"") and ($_POST['コメント']<>"") and ($_POST['パスワアド']<>"") and (isset($_POST['編集ボタン']))){

try{
//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用
	//ここに処理を記載
$id=$_SESSION["suuji"];
$nm=$_SESSION["namae"];
$kome=$_SESSION["komento"];
$pasu=$_SESSION["pas"];
$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");
$pasu=mb_convert_encoding($pasu,"UTF-8","sjis");

$sql="update tbsan set name=$_POST['名前'],comment=$_POST['コメント'],pass=$_POST['パスワアド'] where id=$id and pass='$_POST[$pasuhen]'";
$result=$pdo->query($sql);

	//接続終了
	$pdo=null;
}

//接続に失敗した際のエラー処理
catch(PDOException $e){
	print('エラーが発生しました。;'.$e->getMessage());
	die();
}

	header("location:mission_2-15.php");
}
?>

<html>
<head>
<meta charset="Shift_JIS" />
<title>写真ブログ</title>
</head>
<body>
<h1>編集フォーム</h1>
<form method="post" action="mission_2-15-2.php">
<p>
	名前：<input type="text" name="名前" value="<?php echo $_SESSION['namae']; ?>"/><br/>
	コメント：<input type="text" name="コメント" value="<?php echo $_SESSION['komento']; ?>"/><br/>
	パスワード：<input type="text" name="パスワアド" value="<?php echo $_SESSION['pas']; ?>"/><br/>
	<input type="submit" name="編集ボタン" value="編集"><br/>
</p>
</form>
</body>
</html>