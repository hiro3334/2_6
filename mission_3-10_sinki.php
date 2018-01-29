<?php
//DBにMysql、データベース名を指定。
$dsn='データベース名';
//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';

$password='パスワード';

if(($_POST['touroku_name']<>"") and ($_POST['touroku_pass']<>"") and ($_POST['touroku_mail']<>"") and (isset($_POST['touroku']))){

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //文字化け対策用

	//ここに処理を記載
//データ入力
$sql = $pdo -> prepare("INSERT INTO user_tb(user_name,user_pass,user_id,user_time,user_tag) VALUES (:user_name,:user_pass,:user_id,:user_time,:user_tag)");
$sql -> bindParam(':user_name', $user_name, PDO::PARAM_STR);
$sql -> bindParam(':user_pass', $user_pass, PDO::PARAM_STR);
$sql -> bindParam(':user_id', $user_id, PDO::PARAM_STR);
$sql -> bindParam(':user_time', $user_time, PDO::PARAM_STR);
$sql -> bindParam(':user_tag', $user_tag, PDO::PARAM_STR);

$user_name=$_POST['touroku_name'];
$user_pass=$_POST['touroku_pass'];
$user_id=uniqid("",1);
$user_time=date("Y/m/d H:i:s");
$user_tag='kari';

$user_name=mb_convert_encoding($user_name,"UTF-8","sjis");
$user_pass=mb_convert_encoding($user_pass,"UTF-8","sjis");
$user_id=mb_convert_encoding($user_id,"UTF-8","sjis");
$user_time=mb_convert_encoding($user_time,"UTF-8","sjis");
$user_tag=mb_convert_encoding($user_tag,"UTF-8","sjis");

$sql -> execute();

//メールを送信
$idd=$user_id;
$pass=$_POST['touroku_pass'];

mb_language("Japanese");
mb_internal_encoding("Shift-JIS");

$to=$_POST['touroku_mail'];
$subject='仮登録完了と本登録のお願い';
$message="ユーザーID ： $idd パスワード： $pass  /ユーザー登録はまだ仮登録の状態です。右のURLをクリックすると本登録が完了します。"."http://co-645.99sv-coco.com/mission_3-10_tourokuhandan.php?source=$idd";
$headers='From: from@hogehoge.co.jp'."\r\n";

mb_send_mail($to,$subject,$message,$headers);
}elseif(($_POST['touroku_name']<>"") and ($_POST['touroku_pass']=="") and ($_POST['touroku_mail']=="") and (isset($_POST['touroku']))){
echo "パスワードが入力されていません";
}

?>

<html>
<head>
<meta charset="Shift_JIS" />
<link rel="stylesheet"type="text/css" href="mission_3-10_keiziban.css">
</head>
<body class="sample1">
<h1>写真好きが集まるブログ　新規登録</h1>
<title>写真チャット　新規登録</title>
<form method="post" action="mission_3-10_sinki.php">
	ユーザー登録<br/>
	名前：<input type="text" name="touroku_name"/><br/>
	パスワード：<input type="password" name="touroku_pass"/><br/>
	メールアドレス：<input type="text" name="touroku_mail"/><br/>
	<input type="submit" name="touroku" value="登録する"><br/>
	※「登録する」ボタンを押した後、入力したメールアドレスに仮登録完了メールが送られます。<br>
	　ログインに必要なIDは自動生成されます。
</p>
</form>
</body>
</html>

<?php
/*

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //文字化け対策用

	//ここに処理を記載

//ユーザー情報の表示
echo"<hr>";
$sql='SELECT * FROM user_tb ORDER BY user_time';
$results=$pdo->query($sql);
foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
 echo '名前：'.$row['user_name'].' ';
 echo 'ユーザーID：'.$row['user_id'].' ';
 echo 'パスワード：'.$row['user_pass'].' ';
 echo $row['user_time'].' ';
 echo $row['user_tag'].'<br>';
}

*/
?>