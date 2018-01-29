<?php
session_start()
?>

<?php
//DBにMysql、データベース名を指定。
$dsn='データベース名';
//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';

$password='パスワード';

if(isset($_POST['roguin'])){
	if(empty($_POST['roguin_id'])){
	echo "ユーザーIDが未入力です。";
	}elseif(empty($_POST['roguin_pass'])){
	echo "パスワードが未入力です。";
	}

if(!empty($_POST['roguin_id']) && !empty($_POST['roguin_pass'])){

$rogid=$_POST['roguin_id'];
$rogpass=$_POST['roguin_pass'];

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //文字化け対策用
	//ここに処理を記載
$idch="SELECT user_tag FROM user_tb where user_id='$rogid'";
$idchh=$pdo->query($idch);
$idchhh=$idchh->fetchColumn();
if($idchhh=='hon'){

$to="SELECT user_pass FROM user_tb where user_id='$rogid'";
$tor=$pdo->query($to);
$torr=$tor->fetchColumn();

if($torr==$rogpass){
$na="SELECT user_name FROM user_tb where user_id='$rogid'";
$nar=$pdo->query($na);
$narr=$nar->fetchColumn();

$pa="SELECT user_pass FROM user_tb where user_id='$rogid'";
$par=$pdo->query($pa);
$parr=$par->fetchColumn();

$id="SELECT user_id FROM user_tb where user_id='$rogid'";
$idr=$pdo->query($id);
$idrr=$idr->fetchColumn();

session_start();
$_SESSION["user_name"]=$narr;
$_SESSION["user_pass"]=$parr;
$_SESSION["user_id"]=$idrr;

header("location:mission_3-10_keiziban.php");
}else{
echo "IDかパスワードが違います";
}
}else{
echo "仮登録状態のため、ログインできません";
}
$pdo=null;

}
}

?>

<html>
<head>
<meta charset="Shift_JIS" />
<link rel="stylesheet"type="text/css" href="mission_3-10_keiziban.css">
</head>
<body class="sample1">
<h1>写真好きが集まるブログ＜入口＞</h1>
<form method="post" action="mission_3-10.php">
<p>
	ID：<input type="text" name="roguin_id" value="<?php echo $_SESSION["user_id"]; ?>"/><br/>
	パスワード：<input type="password" name="roguin_pass" value="<?php echo $_SESSION["user_pass"]; ?>"/><br/>
	<input type="submit" name="roguin" value="入場する">
</p>
</form>
<a href="http://co-645.99sv-coco.com/mission_3-10_sinki.php">ID・パスワードの新規登録はこちら</a>
</body>
</html>
