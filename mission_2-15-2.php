<?php
session_start()
?>

<?php

if(($_POST['���O']<>"") and ($_POST['�R�����g']<>"") and ($_POST['�p�X���A�h']<>"") and (isset($_POST['�ҏW�{�^��']))){

try{
//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p
	//�����ɏ������L��
$id=$_SESSION["suuji"];
$nm=$_SESSION["namae"];
$kome=$_SESSION["komento"];
$pasu=$_SESSION["pas"];
$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");
$pasu=mb_convert_encoding($pasu,"UTF-8","sjis");

$sql="update tbsan set name=$_POST['���O'],comment=$_POST['�R�����g'],pass=$_POST['�p�X���A�h'] where id=$id and pass='$_POST[$pasuhen]'";
$result=$pdo->query($sql);

	//�ڑ��I��
	$pdo=null;
}

//�ڑ��Ɏ��s�����ۂ̃G���[����
catch(PDOException $e){
	print('�G���[���������܂����B;'.$e->getMessage());
	die();
}

	header("location:mission_2-15.php");
}
?>

<html>
<head>
<meta charset="Shift_JIS" />
<title>�ʐ^�u���O</title>
</head>
<body>
<h1>�ҏW�t�H�[��</h1>
<form method="post" action="mission_2-15-2.php">
<p>
	���O�F<input type="text" name="���O" value="<?php echo $_SESSION['namae']; ?>"/><br/>
	�R�����g�F<input type="text" name="�R�����g" value="<?php echo $_SESSION['komento']; ?>"/><br/>
	�p�X���[�h�F<input type="text" name="�p�X���A�h" value="<?php echo $_SESSION['pas']; ?>"/><br/>
	<input type="submit" name="�ҏW�{�^��" value="�ҏW"><br/>
</p>
</form>
</body>
</html>