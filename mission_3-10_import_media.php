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
//DB��Mysql�A�f�[�^�x�[�X�����w��B
$dsn='�f�[�^�x�[�X��';

//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';
$password='�p�X���[�h';

try{
//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
//���������΍��p
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
