<?php
$param=strstr($_SERVER['REQUEST_URI'],'source');

parse_str($param);

echo $source;

//DB��Mysql�A�f�[�^�x�[�X�����w��B
$dsn='�f�[�^�x�[�X��';
//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';

$password='�p�X���[�h';

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p
	//�����ɏ������L��
$id="SELECT user_pass FROM user_tb where user_id='$source'";
$idd=$pdo->query($id);
$iddd=$idd->fetchColumn();
if($iddd)
{
$sql="update user_tb set user_tag='hon' where user_id='$source'";
$result=$pdo->query($sql);

header("location:mission_3-10.php");
}

//�ڑ�������
$pdo=null;
?>

<html>
<head>
<meta cherset="Shift-JIS">
</head>
<h1>���o�^���[�����痈��y�[�W</h1>
<title>��</title>
<body>

</body>
</html>
