<?php
session_start()
?>

<?php
//DB��Mysql�A�f�[�^�x�[�X�����w��B
$dsn='�f�[�^�x�[�X��';
//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';

$password='�p�X���[�h';

if(isset($_POST['roguin'])){
	if(empty($_POST['roguin_id'])){
	echo "���[�U�[ID�������͂ł��B";
	}elseif(empty($_POST['roguin_pass'])){
	echo "�p�X���[�h�������͂ł��B";
	}

if(!empty($_POST['roguin_id']) && !empty($_POST['roguin_pass'])){

$rogid=$_POST['roguin_id'];
$rogpass=$_POST['roguin_pass'];

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //���������΍��p
	//�����ɏ������L��
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
echo "ID���p�X���[�h���Ⴂ�܂�";
}
}else{
echo "���o�^��Ԃ̂��߁A���O�C���ł��܂���";
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
<h1>�ʐ^�D�����W�܂�u���O��������</h1>
<form method="post" action="mission_3-10.php">
<p>
	ID�F<input type="text" name="roguin_id" value="<?php echo $_SESSION["user_id"]; ?>"/><br/>
	�p�X���[�h�F<input type="password" name="roguin_pass" value="<?php echo $_SESSION["user_pass"]; ?>"/><br/>
	<input type="submit" name="roguin" value="���ꂷ��">
</p>
</form>
<a href="http://co-645.99sv-coco.com/mission_3-10_sinki.php">ID�E�p�X���[�h�̐V�K�o�^�͂�����</a>
</body>
</html>
