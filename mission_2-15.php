<?php
//DB��Mysql�A�f�[�^�x�[�X�����w��B
$dsn='�f�[�^�x�[�X��';
//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';

$password='�p�X���[�h';

if(($_POST['���O']<>"") and ($_POST['�R�����g']<>"") and ($_POST['�p�X���A�h']<>"") and (isset($_POST['����']))){
//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
	$stmt=$pdo->query('SET NAMES UTF-8'); //���������΍��p

	//�����ɏ������L��


//�f�[�^����


$sql = $pdo -> prepare("INSERT INTO tbsan(id,name,comment,time,pass) VALUES (:id,:name,:comment,:time,:pass)");
$sql -> bindParam(':id', $id, PDO::PARAM_INT);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':time', $time, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

	//id�̒l���w��
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
$name=$_POST['���O'];
$comment=$_POST['�R�����g'];
$time=date("Y/m/d H:i:s");
$pass=$_POST['�p�X���A�h'];

$id=mb_convert_encoding($id,"UTF-8","sjis");
$name=mb_convert_encoding($name,"UTF-8","sjis");
$comment=mb_convert_encoding($comment,"UTF-8","sjis");
$time=mb_convert_encoding($time,"UTF-8","sjis");
$pass=mb_convert_encoding($pass,"UTF-8","sjis");

$sql -> execute();

	//�ڑ��I��
	$pdo=null;

}

//�폜����
if(($_POST['�폜']<>"") and($_POST['pasusaku']<>"") and (isset($_POST['�폜����']))){
$saku=$_POST['�폜'];
$pasu=$_POST['pasusaku'];
//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p
	//�����ɏ������L��

$sql="delete from tbsan where id=$saku and pass='$pasu'";
$result=$pdo->query($sql);

	//�ڑ��I��
	$pdo=null;
}

//�ҏW���郌�R�[�h���w��
if(($_POST['�ҏW�ԍ�']<>"") and ($_POST['pasuhen']<>"") and (isset($_POST['�ҏW�ԍ��w��{�^��']))){
$henban=$_POST['�ҏW�ԍ�'];
$henpas=$_POST['pasuhen'];

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p

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

echo "����"."<br/>\n";
echo "�y�ҏW�Ώہz"."<br/>\n";
echo "$henban"." ";
echo "���O�F"."$narr"." ";
echo "�R�����g�F"."$corr";

}else{
echo "�p�X���[�h���Ⴂ�܂�";
}

	//�ڑ��I��
	$pdo=null;
}


//���R�[�h��ҏW����
if(($_POST['�ҏW���O']<>"") and ($_POST['�ҏW�R�����g']<>"") and ($_POST['�ҏW�p�X���A�h']<>"") and (isset($_POST['�ҏW����']))){

//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p
	//�����ɏ������L��
$id=$_POST['�����ւ�'];
$nm=$_POST['�ҏW���O'];
$kome=$_POST['�ҏW�R�����g'];
$pasu=$_POST['�ҏW�p�X���A�h'];

$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");

$sql="update tbsan set name='$nm',comment='$kome',pass='$pasu' where id=$id";
$result=$pdo->query($sql);

	//�ڑ��I��
	$pdo=null;
}

?>

<html>
<head>
<meta charset="Shift_JIS" />
</head>
<body>
<h1>�ʐ^�D�����W�܂�u���O</h1>
<form method="post" action="mission_2-15.php">
<p>
	���O�F<input type="text" name="���O"><br/>
	�R�����g�F<input type="text" name="�R�����g"><br/>
	�p�X���[�h�F<input type="password" name="�p�X���A�h"><br/>
	<input type="submit" name="����" value="�V�K����"><br/>
	�폜�Ώ۔ԍ��F<input type="text" name="�폜"/><br/>
	�p�X���[�h�F<input type="text" name="pasusaku"><br/>
	<input type="submit" name="�폜����" value="�폜"><br/>
	�ҏW�Ώ۔ԍ��F<input type="text" name="�ҏW�ԍ�"><br/>
	�p�X���[�h�F<input type="text" name="pasuhen"><br/>
	<input type="submit" name="�ҏW�ԍ��w��{�^��" value="�ҏW����ԍ����w��"><br/>	
	<input type="hidden" name="�����ւ�" value="<?php echo $henban; ?>"/>
	���O�F<input type="text" name="�ҏW���O" value="<?php echo $narr; ?>"/><br/>
	�R�����g�F<input type="text" name="�ҏW�R�����g" value="<?php echo $corr; ?>"/><br/>
	�p�X���[�h�F<input type="password" name="�ҏW�p�X���A�h" value="<?php echo $parr; ?>"/><br/>
	<input type="submit" name="�ҏW����" value="�ҏW����">
</p>
</form>
</body>
</html>

<?php
//�f�[�^��\������
//�f�[�^�x�[�X�ɐڑ�
	$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //���������΍��p
	//�����ɏ������L��

//�f�[�^�\��
echo"<hr>";
$sql='SELECT * FROM tbsan ORDER BY id';
$results=$pdo->query($sql);
foreach ($results as $row){
	//$row�̒��ɂ̓e�[�u���̃J������������
 echo $row['id'].' ';
 echo $row['name'].' ';
 echo $row['comment'].' ';
 echo $row['time'].'<br>';
}



	//�ڑ��I��
	$pdo=null;

?>
