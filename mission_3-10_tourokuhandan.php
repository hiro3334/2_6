<?php
$param=strstr($_SERVER['REQUEST_URI'],'source');

parse_str($param);

echo $source;

//DBにMysql、データベース名を指定。
$dsn='データベース名';
//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';

$password='パスワード';

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用
	//ここに処理を記載
$id="SELECT user_pass FROM user_tb where user_id='$source'";
$idd=$pdo->query($id);
$iddd=$idd->fetchColumn();
if($iddd)
{
$sql="update user_tb set user_tag='hon' where user_id='$source'";
$result=$pdo->query($sql);

header("location:mission_3-10.php");
}

//接続を解除
$pdo=null;
?>

<html>
<head>
<meta cherset="Shift-JIS">
</head>
<h1>仮登録メールから来るページ</h1>
<title>仮</title>
<body>

</body>
</html>
