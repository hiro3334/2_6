<?php
    if(isset($_GET["target"]) && $_GET["target"] !== ""){
        $target = $_GET["target"];
    }
    else{
        header("Location: mission_3-10_keiziban.php");
    }
    $MIMETypes = array(
        'png' => 'image/png',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'mp4' => 'video/mp4'
    );
//DBにMysql、データベース名を指定。
$dsn='データベース名';

//DBに接続するためのユーザー名・パスワードを設定
$user='ユーザー名';
$password='パスワード';

try{
//データベースに接続
	$pdo=new PDO($dsn,$user,$password);
//文字化け対策用
$stmt=$pdo->query('SET NAMES utf8');

        $sql = "SELECT * FROM media_tb WHERE media_fname = :target;";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":target", $target, PDO::PARAM_STR);
        $stmt -> execute();
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        header("Content-Type: ".$MIMETypes[$row["media_extension"]]);
        echo ($row["media_raw_data"]);
    }
    catch (PDOException $e) {
        echo("<p>500 Inertnal Server Error</p>");
        exit($e->getMessage());
    }
?>
