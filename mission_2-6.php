<?php

//�ҏW�f�[�^�̎w��

if(($_POST['�ҏW�ԍ�']<>"") and ($_POST['pasuhen']<>"") and (isset($_POST['�ҏW�ԍ��w��{�^��']))){
$filename="kadai2-6.txt";
//�t�@�C����S�Ĕz��ɓ����
$ret_array=file($filename);
//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){
	//�z������Ԃɕ\������
	$arr=explode("<>",$ret_array[$i]);
	//���͂��ꂽ�����Ɣz��̓��̐�������v���邩�̊m�F
	if($arr[0]==$_POST['�ҏW�ԍ�']){
$pasuhen=$arr[4];
}
}
if($pasuhen==$_POST['pasuhen']){

//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){
	//�z������Ԃɕ\������
	$arr=explode("<>",$ret_array[$i]);
	//���͂��ꂽ�����Ɣz��̓��̐�������v���邩�̊m�F
	if($arr[0]==$_POST['�ҏW�ԍ�']){
session_start();
$_SESSION["suuji"]=$arr[0];
$_SESSION["namae"]=$arr[1];
$_SESSION["komento"]=$arr[2];
$_SESSION["pas"]=$arr[4];
}
}

echo "�y�ҏW�Ώہz"."<br/>\n";
echo "$suuji"." ";
echo "���O�F"."$namae"." ";
echo "�R�����g�F"."$komento";


header("location:mission_2-6-2.php");
}else{
echo "�p�X���[�h���Ⴂ�܂�";
}



}


?>

<html>
<head>
<meta charset="Shift_JIS" />
<title>�ʐ^�u���O</title>
</head>
<body>
<h1>�ʐ^�D�����W�܂�u���O</h1>
<form method="post" action="mission_2-6.php">
<p>
	���O�F<input type="text" name="���O" value="<?php echo $namae; ?>"/><br/>
	�R�����g�F<input type="text" name="�R�����g" value="<?php echo $komento; ?>"/><br/>
	�p�X���[�h�F<input type="password" name="�p�X���A�h"><br/>
	<input type="submit" name="����" value="�V�K����"><br/>
	�폜�Ώ۔ԍ��F<input type="text" name="�폜"/><br/>
	�p�X���[�h�F<input type="password" name="pasusaku"><br/>
	<input type="submit" name="�폜����" value="�폜"><br/>
	�ҏW�Ώ۔ԍ��F<input type="text" name="�ҏW�ԍ�"><br/>
	�p�X���[�h�F<input type="password" name="pasuhen"><br/>
	<input type="submit" name="�ҏW�ԍ��w��{�^��" value="�ҏW����ԍ����w��"><br/>
	<input type="hidden" name="�����ւ�" value="<?php echo $suuji; ?>"/>
</p>
</form>
</body>
</html>

<?php
$filename='kadai2-6.txt';
$ret_array=file($filename);

//���̓t�H�[��
if(($_POST['���O']<>"") and ($_POST['�R�����g']<>"") and ($_POST['�p�X���A�h']<>"") and (isset($_POST['����']))){
//�e�L�X�g�t�@�C�����쐬����
$filename='kadai2-6.txt';

	if(is_readable($filename)){
	$lines=file($filename);
	$lastLine=$lines[count($lines)-1];
	$numb=explode("<>", $lastLine);
	$num=$numb[0]+1;
	}else{
		$num=1;
	}

$fp=fopen("kadai2-6.txt","a");
fwrite($fp,$num."<>".$_POST['���O']."<>".$_POST['�R�����g']."<>".date("Y/m/d")." ".date("H:i:s")."<>".$_POST['�p�X���A�h']."<>"."\n");
fclose($fp);

}elseif((($_POST['���O']<>"") and ($_POST['�R�����g']<>""))or(($_POST['�R�����g']<>"") and ($_POST['�p�X���A�h']<>""))or(($_POST['���O']<>"")and($_POST['�p�X���A�h']<>""))or($_POST['���O']<>"")or($_POST['�R�����g']<>"")or($_POST['�p�X���A�h']<>"")and(isset($_POST['����']))){
echo "�����͂̍��ڂ�����܂�"."<br />\n";
}

//�폜�t�H�[��
if(($_POST['�폜']<>"") and($_POST['pasusaku']<>"") and (isset($_POST['�폜����']))){

$filename="kadai2-6.txt";
//�t�@�C����S�Ĕz��ɓ����
$ret_array=file($filename);
//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){
	//�z������Ԃɕ\������
	$arr=explode("<>",$ret_array[$i]);
	//���͂��ꂽ�����Ɣz��̓��̐�������v���邩�̊m�F
	if($arr[0]==$_POST['�폜']){
$pasusaku=$arr[4];
}
}
if($pasusaku==$_POST['pasusaku']){

//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){
	//�z������Ԃɕ\������
	$arr=explode("<>",$ret_array[$i]);
	if(($arr[0] <> $_POST['�폜']) and ($arr[4]<>$_POST['pasusaku'])){
$hensuu[$i]="$arr[0]"."<>"."$arr[1]"."<>"."$arr[2]"."<>"."$arr[3]"."<>"."$arr[4]"."<>"."\n";
}
}


$fp=fopen("kadai2-6.txt","w+");
for($i=0;  $i < count($ret_array);  ++$i){
fwrite($fp,$hensuu[$i]);
}
fclose($fp);

}else{
echo "�p�X���[�h���Ⴂ�܂�"."<br />\n";
}

}

$filename='kadai2-6.txt';
$ret_array=file($filename);

//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){

	//�z������Ԃɕ\������
	$arr=explode("<>",$ret_array[$i]);
	echo ("$arr[0]"." "."$arr[1]"." "."$arr[2]"." "."$arr[3]"." "."<br />\n");
	}

?>

