<?php
//DB��Mysql�A�f�[�^�x�[�X�����w��B
$dsn='�f�[�^�x�[�X��';
//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';

$password='�p�X���[�h';

if(($_POST['touroku_name']<>"") and ($_POST['touroku_pass']<>"") and ($_POST['touroku_mail']<>"") and (isset($_POST['touroku']))){

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //���������΍��p

	//�����ɏ������L��
//�f�[�^����
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

//���[���𑗐M
$idd=$user_id;
$pass=$_POST['touroku_pass'];

mb_language("Japanese");
mb_internal_encoding("Shift-JIS");

$to=$_POST['touroku_mail'];
$subject='���o�^�����Ɩ{�o�^�̂��肢';
$message="���[�U�[ID �F $idd �p�X���[�h�F $pass  /���[�U�[�o�^�͂܂����o�^�̏�Ԃł��B�E��URL���N���b�N����Ɩ{�o�^���������܂��B"."http://co-645.99sv-coco.com/mission_3-10_tourokuhandan.php?source=$idd";
$headers='From: from@hogehoge.co.jp'."\r\n";

mb_send_mail($to,$subject,$message,$headers);
}elseif(($_POST['touroku_name']<>"") and ($_POST['touroku_pass']=="") and ($_POST['touroku_mail']=="") and (isset($_POST['touroku']))){
echo "�p�X���[�h�����͂���Ă��܂���";
}

?>

<html>
<head>
<meta charset="Shift_JIS" />
<link rel="stylesheet"type="text/css" href="mission_3-10_keiziban.css">
</head>
<body class="sample1">
<h1>�ʐ^�D�����W�܂�u���O�@�V�K�o�^</h1>
<title>�ʐ^�`���b�g�@�V�K�o�^</title>
<form method="post" action="mission_3-10_sinki.php">
	���[�U�[�o�^<br/>
	���O�F<input type="text" name="touroku_name"/><br/>
	�p�X���[�h�F<input type="password" name="touroku_pass"/><br/>
	���[���A�h���X�F<input type="text" name="touroku_mail"/><br/>
	<input type="submit" name="touroku" value="�o�^����"><br/>
	���u�o�^����v�{�^������������A���͂������[���A�h���X�ɉ��o�^�������[���������܂��B<br>
	�@���O�C���ɕK�v��ID�͎�����������܂��B
</p>
</form>
</body>
</html>

<?php
/*

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //���������΍��p

	//�����ɏ������L��

//���[�U�[���̕\��
echo"<hr>";
$sql='SELECT * FROM user_tb ORDER BY user_time';
$results=$pdo->query($sql);
foreach ($results as $row){
	//$row�̒��ɂ̓e�[�u���̃J������������
 echo '���O�F'.$row['user_name'].' ';
 echo '���[�U�[ID�F'.$row['user_id'].' ';
 echo '�p�X���[�h�F'.$row['user_pass'].' ';
 echo $row['user_time'].' ';
 echo $row['user_tag'].'<br>';
}

*/
?>