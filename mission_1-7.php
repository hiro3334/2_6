<html>
<head>
<meta charset="Shift_JIS" />
</head>
</html>

<?php
//�ǂݍ��ރt�@�C�����̎w��
$file_name="kadai1-6.txt";
//�t�@�C����S�Ĕz��ɓ����
$ret_array=file($file_name);
//�擾�����t�@�C���f�[�^�i�z��j��S�ĕ\������
for($i=0;  $i < count($ret_array);  ++$i){
	//�z������Ԃɕ\������
	echo($ret_array[$i]."<br />\n");
	}

?>
