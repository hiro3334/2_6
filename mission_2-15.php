<?php
//DBにMysql、データベース名を指定。
$dsn='データベース名';
//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';

$password='パスワード';

if(($_POST['名前']<>"") and ($_POST['コメント']<>"") and ($_POST['パスワアド']<>"") and (isset($_POST['入力']))){
//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //文字化け対策用

	//ここに処理を記載


//データ入力


$sql = $pdo -> prepare("INSERT INTO tbsan(id,name,comment,time,pass) VALUES (:id,:name,:comment,:time,:pass)");
$sql -> bindParam(':id', $id, PDO::PARAM_INT);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':time', $time, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

	//idの値を指定
	$sonzai='SELECT * FROM tbsan where id = "?"';
	$result=$pdo -> query($sonzai);
	if($result <> 0){
	$numdai="SELECT MAX(id) FROM tbsan";
	$numdaii=$pdo -> query($numdai);
	$max=$numdaii->fetchColumn();
	$num=$max + 1;
	}else{
	$num=1;
	}

$id=$num;
$name=$_POST['名前'];
$comment=$_POST['コメント'];
$time=date("Y/m/d H:i:s");
$pass=$_POST['パスワアド'];

$id=mb_convert_encoding($id,"UTF-8","sjis");
$name=mb_convert_encoding($name,"UTF-8","sjis");
$comment=mb_convert_encoding($comment,"UTF-8","sjis");
$time=mb_convert_encoding($time,"UTF-8","sjis");
$pass=mb_convert_encoding($pass,"UTF-8","sjis");

$sql -> execute();

	//接続終了
	$pdo=null;

}

//削除する
if(($_POST['削除']<>"") and($_POST['pasusaku']<>"") and (isset($_POST['削除する']))){
$saku=$_POST['削除'];
$pasu=$_POST['pasusaku'];
//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用
	//ここに処理を記載

$sql="delete from tbsan where id=$saku and pass='$pasu'";
$result=$pdo->query($sql);

	//接続終了
	$pdo=null;
}

//編集するレコードを指定
if(($_POST['編集番号']<>"") and ($_POST['pasuhen']<>"") and (isset($_POST['編集番号指定ボタン']))){
$henban=$_POST['編集番号'];
$henpas=$_POST['pasuhen'];

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用

$pa="SELECT pass FROM tbsan where id=$henban";
$par=$pdo->query($pa);
$parr=$par->fetchColumn();
var_dump($parr);

if($parr==$henpas){
$na="SELECT name FROM tbsan where id=$henban";
$co="SELECT comment FROM tbsan where id='$henban'";

$nar=$pdo->query($na);
$cor=$pdo->query($co);

$narr=$nar->fetchColumn();
$corr=$cor->fetchColumn();

echo "成功"."<br/>\n";
echo "【編集対象】"."<br/>\n";
echo "$henban"." ";
echo "名前："."$narr"." ";
echo "コメント："."$corr";

}else{
echo "パスワードが違います";
}

	//接続終了
	$pdo=null;
}


//レコードを編集する
if(($_POST['編集名前']<>"") and ($_POST['編集コメント']<>"") and ($_POST['編集パスワアド']<>"") and (isset($_POST['編集する']))){

//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用
	//ここに処理を記載
$id=$_POST['差し替え'];
$nm=$_POST['編集名前'];
$kome=$_POST['編集コメント'];
$pasu=$_POST['編集パスワアド'];

$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");

$sql="update tbsan set name='$nm',comment='$kome',pass='$pasu' where id=$id";
$result=$pdo->query($sql);

	//接続終了
	$pdo=null;
}

?>

<html>
<head>
<meta charset="Shift_JIS" />
</head>
<body>
<h1>写真好きが集まるブログ</h1>
<form method="post" action="mission_2-15.php">
<p>
	名前：<input type="text" name="名前"><br/>
	コメント：<input type="text" name="コメント"><br/>
	パスワード：<input type="password" name="パスワアド"><br/>
	<input type="submit" name="入力" value="新規入力"><br/>
	削除対象番号：<input type="text" name="削除"/><br/>
	パスワード：<input type="text" name="pasusaku"><br/>
	<input type="submit" name="削除する" value="削除"><br/>
	編集対象番号：<input type="text" name="編集番号"><br/>
	パスワード：<input type="text" name="pasuhen"><br/>
	<input type="submit" name="編集番号指定ボタン" value="編集する番号を指定"><br/>	
	<input type="hidden" name="差し替え" value="<?php echo $henban; ?>"/>
	名前：<input type="text" name="編集名前" value="<?php echo $narr; ?>"/><br/>
	コメント：<input type="text" name="編集コメント" value="<?php echo $corr; ?>"/><br/>
	パスワード：<input type="password" name="編集パスワアド" value="<?php echo $parr; ?>"/><br/>
	<input type="submit" name="編集する" value="編集する">
</p>
</form>
</body>
</html>

<?php
//データを表示する
//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //文字化け対策用
	//ここに処理を記載

//データ表示
echo"<hr>";
$sql='SELECT * FROM tbsan ORDER BY id';
$results=$pdo->query($sql);
foreach ($results as $row){
	//$rowの中にはテーブルのカラム名が入る
 echo $row['id'].' ';
 echo $row['name'].' ';
 echo $row['comment'].' ';
 echo $row['time'].'<br>';
}



	//接続終了
	$pdo=null;

?>
