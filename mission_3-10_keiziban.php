<?php
//SESSIONを使えるようにする
session_start();
?>


<html>
<head>
<meta charset="Shift-JIS"/>
<title>写真チャット</title>
<!-- jquery読み込み -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<!-- スクロール -->
<script type="text/javascript">
<!--一番下に移動-->
$(function(){
	$("a[href^=#page-bottom]").click(function(){
	$('html, body').animate({
		scrollTop: $(document).height()
	},1500);
        return false;
    });
});

</script>
</head>
<body>
<p>
<table border="0" width="500" cellspaacing="0" cellpadding="5" bordercolor="#333333">
<tr><td bgcolor="#FFFFCC">
<font size="6">写真好き集合！</font><br>
<font size="3">～あなたの<font color="#FF0000">ベストショット</font>が見たい～</font>
</td></tr>
</table>
</p>

<div class="scroll_button_btm">
    <a href="#page-bottom">ページの一番下へ</a>
</div>

</body>
</html>

<?php
//DBにMysql、データベース名を指定
$dsn='データベース名';
//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';
$password='パスワード';

/*----------新規入力----------*/
if(isset($_POST['uplode'])){
	if(empty($_POST['名前']) && empty($_POST['コメント']) && empty($_POST['パスワアド'])){
		echo "名前とコメントとパスワードが未入力です。";
		$_SESSION[message]="名前とコメントとパスワードが未入力です。";
	}elseif(empty($_POST['名前']) && empty($_POST['コメント'])){
		echo "名前とコメントが未入力です。";
		$_SESSION[message]="名前とコメントが未入力です。";
	}elseif(empty($_POST['コメント']) && empty($_POST['パスワアド'])){
		echo "コメントとパスワードが未入力です。";
		$_SESSION[message]="コメントとパスワードが未入力です。";
	}elseif(empty($_POST['名前']) && empty($_POST['パスワアド'])){
		echo "名前とパスワードが未入力です。";
		$_SESSION[message]="名前とパスワードが未入力です。";
	}elseif(empty($_POST['名前'])){
		echo "名前が未入力です。";
		$_SESSION[message]="名前が未入力です。";
	}elseif(empty($_POST['コメント'])){
		echo "コメントが未入力です。";
		$_SESSION[message]="コメントが未入力です。";
	}elseif(empty($_POST['パスワアド'])){
		echo "パスワードが未入力です。";
		$_SESSION[message]="パスワードが未入力です。";
	}
if(!empty($_POST['名前']) && !empty($_POST['コメント']) && !empty($_POST['パスワアド'])){
try{
//データベースに接続
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES UTF-8'); //文字化け対策用

//ここに処理を記載
//データ入力
$sql = $pdo -> prepare("INSERT INTO com_tb(com_id,com_name,com_comment,com_time,com_pass) VALUES (:com_id,:com_name,:com_comment,:com_time,:com_pass)");
$sql -> bindParam(':com_id', $com_id, PDO::PARAM_INT);
$sql -> bindParam(':com_name', $com_name, PDO::PARAM_STR);
$sql -> bindParam(':com_comment', $com_comment, PDO::PARAM_STR);
$sql -> bindParam(':com_time', $com_time, PDO::PARAM_STR);
$sql -> bindParam(':com_pass', $com_pass, PDO::PARAM_STR);

	//idの値を指定
	$sonzai='SELECT * FROM com_tb where com_id = "?"';
	$result=$pdo -> query($sonzai);
	if($result <> 0){
	$numdai="SELECT MAX(com_id) FROM com_tb";
	$numdaii=$pdo -> query($numdai);
	$max=$numdaii->fetchColumn();
	$num=$max + 1;
	}else{
	$num=1;
	}

//カラムに値を代入
$com_id=$num;
$com_name=$_POST['名前'];
$com_comment=$_POST['コメント'];
$com_time=date("Y/m/d H:i:s");
$com_pass=$_POST['パスワアド'];

//カラムの値のエンコーディング
$com_id=mb_convert_encoding($com_id,"UTF-8","sjis");
$com_name=mb_convert_encoding($com_name,"UTF-8","sjis");
$com_comment=mb_convert_encoding($com_comment,"UTF-8","sjis");
$com_time=mb_convert_encoding($com_time,"UTF-8","sjis");
$com_pass=mb_convert_encoding($com_pass,"UTF-8","sjis");

$sql -> execute();

/*----------画像/動画のアップロード----------*/
	//ファイルアップロードがあったとき
	if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){

		//エラーチェック
		switch ($_FILES['upfile']['error']) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_NO_FILE:   // 未選択
				throw new RuntimeException('ファイルが選択されていません', 400);
			case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズ超過
				throw new RuntimeException('ファイルサイズが大きすぎます', 400);
			default:
				throw new RuntimeException('その他のエラーが発生しました', 500);
		}

		//画像・動画をバイナリデータにする．
		$media_raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

		//拡張子を見る
		$tmp = pathinfo($_FILES["upfile"]["name"]);
		$media_extension = $tmp["extension"];
		if($media_extension === "jpg" || $media_extension === "jpeg" || $media_extension === "JPG" || $media_extension === "JPEG"){
			$media_extension = "jpeg";
		}
		elseif($media_extension === "png" || $media_extension === "PNG"){
			$media_extension = "png";
		}
		elseif($media_extension === "gif" || $media_extension === "GIF"){
			$media_extension = "gif";
		}
		elseif($media_extension === "mp4" || $media_extension === "MP4"){
			$media_extension = "mp4";
		}
		else{
			echo "非対応ファイルです．<br/>".("<a href=\"mission_3-10_keiziban.php\">戻る</a><br/>");
			$_SESSION[message]="非対応ファイルです．<br/>".("<a href=\"mission_3-10_keiziban.php\">戻る</a><br/>");
			exit(1);
		}

		//DBに格納するファイルネーム設定
		//サーバー側の一時的なファイルネームと取得時刻を結合した文字列にsha256をかける．
		$date = getdate();
		$media_fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
		$media_fname = hash("sha256", $media_fname);

		//画像・動画をDBに格納．
		$sql = "INSERT INTO media_tb (media_fname, media_extension, media_raw_data,media_id) VALUES (:media_fname, :media_extension, :media_raw_data, :media_id);";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindValue(":media_fname",$media_fname, PDO::PARAM_STR);
		$stmt -> bindValue(":media_extension",$media_extension, PDO::PARAM_STR);
		$stmt -> bindValue(":media_raw_data",$media_raw_data, PDO::PARAM_STR);
		$stmt -> bindValue(":media_id",$num, PDO::PARAM_INT);
		$stmt -> execute();
	}
}
catch(PDOException $e){
	echo("<p>500 Inertnal Server Error</p>");
	$_SESSION[message]="<p>500 Inertnal Server Error</p>";
	exit($e->getMessage());
}
//接続終了
$pdo=null;

echo "投稿しました。";
$_SESSION[message]="投稿しました。";
}
}

/*----------削除する----------*/
if(isset($_POST['削除する'])){
	if(empty($_POST['削除']) && empty($_POST['pasusaku'])){
		echo "削除対象番号とパスワードが未入力です。";
		$_SESSION[message]="削除対象番号とパスワードが未入力です。";
	}elseif(empty($_POST['削除'])){
		echo "削除対象番号が未入力です。" ;
		$_SESSION[message]="削除対象番号が未入力です。" ;
	}elseif(empty($_POST['pasusaku'])){
		echo "パスワードが未入力です。";
		$_SESSION[message]="パスワードが未入力です。";
	}

	$saku=$_POST['削除'];
	$pasu=$_POST['pasusaku'];

	if(!empty($_POST['削除'])){
		//データベースに接続
		$pdo=new PDO($dsn,$user,$password);
		$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用

		//入力した番号と一致するデータのパスワードを受け取る
		$pasaku="SELECT com_pass FROM com_tb where com_id='$saku'";
		$pasakuu=$pdo->query($pasaku);
		$pasakuuu=$pasakuu->fetchColumn();
			if($pasakuuu==FALSE){
				echo "入力した番号に該当する投稿が見つかりませんでした。";
				$_SESSION[message2]="入力した番号に該当する投稿が見つかりませんでした。";
			}
		if(!empty($_POST['削除']) && !empty($_POST['pasusaku'])){

		//ここに処理を記載


		//入力したパスワードと一致するか確認
			if($pasakuuu==$pasu){
				//コメントの削除
				$sql="delete from com_tb where com_id=$saku and com_pass='$pasu'";
				//画像・動画の削除
				$sqla="delete from media_tb where media_id=$saku";

				$result=$pdo->query($sql);
				$resulta=$pdo->query($sqla);

				echo "削除できました。";
				$_SESSION[message]="削除できました。";
			}
			else{
				echo "パスワードが違います。";
				$_SESSION[message]="パスワードが違います。";
			}
//接続終了
$pdo=null;
		}
	}
}

/*----------編集するレコードを指定----------*/
if(isset($_POST['編集番号指定ボタン'])){
	if(empty($_POST['編集番号']) && empty($_POST['pasuhen'])){
		echo "編集対象番号とパスワードが未入力です。";
		$_SESSION[message]="編集対象番号とパスワードが未入力です。";
	}elseif(empty($_POST['編集番号'])){
		echo "編集対象番号が未入力です。";
		$_SESSION[message]="編集対象番号が未入力です。";
	}elseif(empty($_POST['pasuhen'])){
		echo "パスワードが未入力です。";
		$_SESSION[message]="パスワードが未入力です。";
	}

	$henban=$_POST['編集番号'];
	$henpas=$_POST['pasuhen'];

	if(!empty($_POST['編集番号'])){
		//データベースに接続
		$pdo=new PDO($dsn,$user,$password);
		$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用

		//入力した番号と一致するデータのパスワードを受け取る
		$pa="SELECT com_pass FROM com_tb where com_id='$henban'";
		$par=$pdo->query($pa);
		$parr=$par->fetchColumn();
		if($parr==FALSE){
			echo "入力した番号に該当する投稿が見つかりませんでした。";
			$_SESSION[message2]="入力した番号に該当する投稿が見つかりませんでした。";
		}
		if(!empty($_POST['編集番号']) && !empty($_POST['pasuhen'])){ 

			//入力したパスワードと一致するか確認
			if($parr==$henpas){
				$parrr=$parr;
				$na="SELECT com_name FROM com_tb where com_id='$henban'";
				$co="SELECT com_comment FROM com_tb where com_id='$henban'";

				$nar=$pdo->query($na);
				$cor=$pdo->query($co);

				$narr=$nar->fetchColumn();
				$corr=$cor->fetchColumn();

				//編集する前の各データを表示
				echo "投稿内容の編集をしてください。"."<br/>\n"."【編集対象】"."<br/>\n"."$henban"." "."名前："."$narr"." "."コメント："."$corr";
				$_SESSION[message]="投稿内容の編集をしてください。"."<br/>\n"."【編集対象】"."<br/>\n"."$henban"." "."名前："."$narr"." "."コメント："."$corr";
			}
			else{
				echo "パスワードが違います。";
				$_SESSION[message]="パスワードが違います。";
			}
//接続終了
$pdo=null;
		}
	}
}

/*----------レコードを編集する----------*/
if(isset($_POST['編集する'])){
	if(empty($_POST['編集名前']) && empty($_POST['編集コメント']) && empty($_POST['編集パスワアド'])){
		echo "名前とコメントとパスワードが未入力です。";
		$_SESSION[message]="名前とコメントとパスワードが未入力です。";
	}elseif(empty($_POST['編集名前']) && empty($_POST['編集コメント'])){
		echo "名前とコメントが未入力です。";
		$_SESSION[message]="名前とコメントが未入力です。";
	}elseif(empty($_POST['編集コメント']) && empty($_POST['編集パスワアド'])){
		echo "コメントとパスワードが未入力です。";
		$_SESSION[message]="コメントとパスワードが未入力です。";
	}elseif(empty($_POST['編集名前']) && empty($_POST['編集パスワアド'])){
		echo "名前とパスワードが未入力です。";
		$_SESSION[message]="名前とパスワードが未入力です。";
	}elseif(empty($_POST['編集名前'])){
		echo "名前が未入力です。";
		$_SESSION[message]="名前が未入力です。";
	}elseif(empty($_POST['編集コメント'])){
		echo "コメントが未入力です。";
		$_SESSION[message]="コメントが未入力です。";
	}elseif(empty($_POST['編集パスワアド'])){
		echo "パスワードが未入力です。";
		$_SESSION[message]="パスワードが未入力です。";
	}

if(!empty($_POST['編集名前']) && !empty($_POST['編集コメント']) && !empty($_POST['編集パスワアド'])){
//データベースに接続
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //文字化け対策用

//ここに処理を記載
//「編集する番号の指定」で指定した番号を受け取る
$id=$_POST['差し替え'];
//各入力項目を変数に格納
$nm=$_POST['編集名前'];
$kome=$_POST['編集コメント'];
$pasu=$_POST['編集パスワアド'];

$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");

//編集する
$sql="update com_tb set com_name='$nm',com_comment='$kome',com_pass='$pasu' where com_id=$id";
$result=$pdo->query($sql);

//接続終了
$pdo=null;
}
}

?>

<html>
<body>

<?php
/*----------データを表示する----------*/
//データベースに接続
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //文字化け対策用
?>

<!---ここに処理を記載--->
<!---データ表示--->
<!---コメントの表示--->
<?php echo"<hr>"; ?>
<!---全てのコメントを受け取る--->
<?php $sql='SELECT * FROM com_tb ORDER BY com_id'; ?>
<?php $results=$pdo->query($sql); ?>
<?php foreach ($results as $row): ?>
<!---各カラムのデータを繋げて表示--->
<!---$rowの中にはテーブルのカラム名が入る--->
<?php	echo $row['com_id'].' ';
	echo $row['com_name'].' ';
	echo $row['com_comment'].' ';
	echo $row['com_time'].'<br>';
	//コメントの投稿番号を変数に格納
	$id=$row['com_id'];
	//DBから取得して表示する．
	//全ての画像・動画のデータを受け取る
	$sql = "SELECT * FROM media_tb ORDER BY media_id";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
?>
	<?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)): ?>
		<!---コメントの投稿番号と一致する番号の画像・動画を指定--->
		<?php if($row["media_id"]==$id): ?>
		<!---動画と画像で場合分け--->
<?php		$target = $row["media_fname"]; ?>
			<?php if($row["media_extension"] == "mp4"): ?>
				<a href=''><?php echo ("<video src=\"mission_3-10_import_media.php?target=$target\" width=\"426\" height=\"240\" controls></video>").'<br>'; ?></a>
			<?php elseif($row["media_extension"] == "jpeg" || $row["media_extension"] == "png" || $row["media_extension"] == "gif"): ?>
				<a href=''><?php echo ("<img src='mission_3-10_import_media.php?target=$target' width=\"240\">").'<br>'; ?></a>
			<?php endif ?>
		<?php endif ?>
	<?php endwhile ?>
<?php echo"<hr>"; ?>
<?php endforeach ?>
<!---接続終了--->
<?php $pdo=null; ?>
</body>
</html>

<?php
/*---メッセージの表示---*/
if(!empty($_SESSION['message']) && !empty($_SESSION['message2'])){
	$_SESSION['message']=null;
	echo $_SESSION['message2'];
	$_SESSION['message2']=null;
}
elseif(!empty($_SESSION['message'])){
	echo $_SESSION['message'];
	$_SESSION['message']=null;
}
elseif(!empty($_SESSION['message2'])){
	echo $_SESSION['message2'];
	$_SESSION['message2']=null;
}
?>

<html>
<head>
<meta charset="Shift_JIS" />
<link rel="stylesheet"type="text/css" href="mission_3-10_keiziban.css">
</head>
<body class="sample1">
<form action="mission_3-10_keiziban.php" enctype="multipart/form-data" method="post">
<!--新規入力-->
<fieldset class="sample1">
<legend><strong>新規入力</strong></legend>
	名前　　　　：<input class="sample1" type="text" name="名前" value=<?php echo $_SESSION["user_name"]; ?>><br/>
	コメント　　：<input class="sample1-2" type="text" name="コメント"><br/>
	パスワード　：<input class="sample1" type="password" name="パスワアド" value=<?php echo $_SESSION["user_pass"]; ?>><br/>
	<label>画像/動画アップロード</label>
	<input type="file" name="upfile"><br>
	※画像はjpeg方式，png方式，gif方式に対応しています．動画はmp4方式のみ対応しています．<br>
	<input type="submit" name="uplode" value="新規入力">
</fieldset>
<!--削除-->
<fieldset class="sample1">
<legend><strong>削除</strong></legend>
	削除対象番号：<input class="sample2" type="text" name="削除"/><br/>
	パスワード　：<input class="sample2" type="text" name="pasusaku"><br/>
	<input type="submit" name="削除する" value="削除"><br/>
</fieldset>
<fieldset class="sample1">
<legend><strong>編集</strong></legend>
<!--編集番号指定-->
	編集対象番号：<input class="sample3" type="text" name="編集番号"><br/>
	パスワード　：<input class="sample3" type="text" name="pasuhen"><br/>
	<input type="submit" name="編集番号指定ボタン" value="編集する番号を指定"><br/>	
	<input type="hidden" name="差し替え" value="<?php echo $henban; ?>"/><br>
<!--編集-->
	名前　　　　：<input class="sample4" type="text" name="編集名前" value="<?php echo $narr; ?>"/><br/>
	コメント　　：<input class="sample4-2" type="text" name="編集コメント" value="<?php echo $corr; ?>"/><br/>
	パスワード　：<input class="sample4" type="password" name="編集パスワアド" value="<?php echo $parrr; ?>"/><br/>
	<input type="submit" name="編集する" value="編集する"><br/>
<!--更新時、同じ場所に飛ぶ-->
	<input type="hidden" name="scroll_top" value="" class="st">
</fieldset>
</form>
</table>
</body>
</html>


<html>
<head>
<meta charset="Shift-JIS>
<link rel="stylesheet"type="text/css" href="mission_3-10_keiziban.css">
<!-- jquery読み込み -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<!-- スクロール -->
<script type="text/javascript">

<!--元の位置に移動-->
$('form').submit(function(){
	var scroll_top = $(window).scrollTop();  <!--送信時の位置情報を取得-->
	$('input.st',this).prop('value',scroll_top); <!--隠しフィールドに位置情報を設定-->
});

window.onload = function(){
<!--ロード時に隠しフィールドから取得した値で位置をスクロール-->
  $(window).scrollTop(<?php echo @$_REQUEST['scroll_top']; ?>);
}

</script>
</head>
</form>
</body>
</html>
