<?php
//SESSION���g����悤�ɂ���
session_start();
?>


<html>
<head>
<meta charset="Shift-JIS"/>
<title>�ʐ^�`���b�g</title>
<!-- jquery�ǂݍ��� -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<!-- �X�N���[�� -->
<script type="text/javascript">
<!--��ԉ��Ɉړ�-->
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
<font size="6">�ʐ^�D���W���I</font><br>
<font size="3">�`���Ȃ���<font color="#FF0000">�x�X�g�V���b�g</font>���������`</font>
</td></tr>
</table>
</p>

<div class="scroll_button_btm">
    <a href="#page-bottom">�y�[�W�̈�ԉ���</a>
</div>

</body>
</html>

<?php
//DB��Mysql�A�f�[�^�x�[�X�����w��
$dsn='�f�[�^�x�[�X��';
//DB�ɐڑ����邽�߂̃��[�U�[���E�p�X���[�h��ݒ�
$user='���[�U�[��';
$password='�p�X���[�h';

/*----------�V�K����----------*/
if(isset($_POST['uplode'])){
	if(empty($_POST['���O']) && empty($_POST['�R�����g']) && empty($_POST['�p�X���A�h'])){
		echo "���O�ƃR�����g�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="���O�ƃR�����g�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['���O']) && empty($_POST['�R�����g'])){
		echo "���O�ƃR�����g�������͂ł��B";
		$_SESSION[message]="���O�ƃR�����g�������͂ł��B";
	}elseif(empty($_POST['�R�����g']) && empty($_POST['�p�X���A�h'])){
		echo "�R�����g�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="�R�����g�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['���O']) && empty($_POST['�p�X���A�h'])){
		echo "���O�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="���O�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['���O'])){
		echo "���O�������͂ł��B";
		$_SESSION[message]="���O�������͂ł��B";
	}elseif(empty($_POST['�R�����g'])){
		echo "�R�����g�������͂ł��B";
		$_SESSION[message]="�R�����g�������͂ł��B";
	}elseif(empty($_POST['�p�X���A�h'])){
		echo "�p�X���[�h�������͂ł��B";
		$_SESSION[message]="�p�X���[�h�������͂ł��B";
	}
if(!empty($_POST['���O']) && !empty($_POST['�R�����g']) && !empty($_POST['�p�X���A�h'])){
try{
//�f�[�^�x�[�X�ɐڑ�
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES UTF-8'); //���������΍��p

//�����ɏ������L��
//�f�[�^����
$sql = $pdo -> prepare("INSERT INTO com_tb(com_id,com_name,com_comment,com_time,com_pass) VALUES (:com_id,:com_name,:com_comment,:com_time,:com_pass)");
$sql -> bindParam(':com_id', $com_id, PDO::PARAM_INT);
$sql -> bindParam(':com_name', $com_name, PDO::PARAM_STR);
$sql -> bindParam(':com_comment', $com_comment, PDO::PARAM_STR);
$sql -> bindParam(':com_time', $com_time, PDO::PARAM_STR);
$sql -> bindParam(':com_pass', $com_pass, PDO::PARAM_STR);

	//id�̒l���w��
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

//�J�����ɒl����
$com_id=$num;
$com_name=$_POST['���O'];
$com_comment=$_POST['�R�����g'];
$com_time=date("Y/m/d H:i:s");
$com_pass=$_POST['�p�X���A�h'];

//�J�����̒l�̃G���R�[�f�B���O
$com_id=mb_convert_encoding($com_id,"UTF-8","sjis");
$com_name=mb_convert_encoding($com_name,"UTF-8","sjis");
$com_comment=mb_convert_encoding($com_comment,"UTF-8","sjis");
$com_time=mb_convert_encoding($com_time,"UTF-8","sjis");
$com_pass=mb_convert_encoding($com_pass,"UTF-8","sjis");

$sql -> execute();

/*----------�摜/����̃A�b�v���[�h----------*/
	//�t�@�C���A�b�v���[�h���������Ƃ�
	if (isset($_FILES['upfile']['error']) && is_int($_FILES['upfile']['error']) && $_FILES["upfile"]["name"] !== ""){

		//�G���[�`�F�b�N
		switch ($_FILES['upfile']['error']) {
			case UPLOAD_ERR_OK: // OK
				break;
			case UPLOAD_ERR_NO_FILE:   // ���I��
				throw new RuntimeException('�t�@�C�����I������Ă��܂���', 400);
			case UPLOAD_ERR_INI_SIZE:  // php.ini��`�̍ő�T�C�Y����
				throw new RuntimeException('�t�@�C���T�C�Y���傫�����܂�', 400);
			default:
				throw new RuntimeException('���̑��̃G���[���������܂���', 500);
		}

		//�摜�E������o�C�i���f�[�^�ɂ���D
		$media_raw_data = file_get_contents($_FILES['upfile']['tmp_name']);

		//�g���q������
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
			echo "��Ή��t�@�C���ł��D<br/>".("<a href=\"mission_3-10_keiziban.php\">�߂�</a><br/>");
			$_SESSION[message]="��Ή��t�@�C���ł��D<br/>".("<a href=\"mission_3-10_keiziban.php\">�߂�</a><br/>");
			exit(1);
		}

		//DB�Ɋi�[����t�@�C���l�[���ݒ�
		//�T�[�o�[���̈ꎞ�I�ȃt�@�C���l�[���Ǝ擾���������������������sha256��������D
		$date = getdate();
		$media_fname = $_FILES["upfile"]["tmp_name"].$date["year"].$date["mon"].$date["mday"].$date["hours"].$date["minutes"].$date["seconds"];
		$media_fname = hash("sha256", $media_fname);

		//�摜�E�����DB�Ɋi�[�D
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
//�ڑ��I��
$pdo=null;

echo "���e���܂����B";
$_SESSION[message]="���e���܂����B";
}
}

/*----------�폜����----------*/
if(isset($_POST['�폜����'])){
	if(empty($_POST['�폜']) && empty($_POST['pasusaku'])){
		echo "�폜�Ώ۔ԍ��ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="�폜�Ώ۔ԍ��ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['�폜'])){
		echo "�폜�Ώ۔ԍ��������͂ł��B" ;
		$_SESSION[message]="�폜�Ώ۔ԍ��������͂ł��B" ;
	}elseif(empty($_POST['pasusaku'])){
		echo "�p�X���[�h�������͂ł��B";
		$_SESSION[message]="�p�X���[�h�������͂ł��B";
	}

	$saku=$_POST['�폜'];
	$pasu=$_POST['pasusaku'];

	if(!empty($_POST['�폜'])){
		//�f�[�^�x�[�X�ɐڑ�
		$pdo=new PDO($dsn,$user,$password);
		$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p

		//���͂����ԍ��ƈ�v����f�[�^�̃p�X���[�h���󂯎��
		$pasaku="SELECT com_pass FROM com_tb where com_id='$saku'";
		$pasakuu=$pdo->query($pasaku);
		$pasakuuu=$pasakuu->fetchColumn();
			if($pasakuuu==FALSE){
				echo "���͂����ԍ��ɊY�����铊�e��������܂���ł����B";
				$_SESSION[message2]="���͂����ԍ��ɊY�����铊�e��������܂���ł����B";
			}
		if(!empty($_POST['�폜']) && !empty($_POST['pasusaku'])){

		//�����ɏ������L��


		//���͂����p�X���[�h�ƈ�v���邩�m�F
			if($pasakuuu==$pasu){
				//�R�����g�̍폜
				$sql="delete from com_tb where com_id=$saku and com_pass='$pasu'";
				//�摜�E����̍폜
				$sqla="delete from media_tb where media_id=$saku";

				$result=$pdo->query($sql);
				$resulta=$pdo->query($sqla);

				echo "�폜�ł��܂����B";
				$_SESSION[message]="�폜�ł��܂����B";
			}
			else{
				echo "�p�X���[�h���Ⴂ�܂��B";
				$_SESSION[message]="�p�X���[�h���Ⴂ�܂��B";
			}
//�ڑ��I��
$pdo=null;
		}
	}
}

/*----------�ҏW���郌�R�[�h���w��----------*/
if(isset($_POST['�ҏW�ԍ��w��{�^��'])){
	if(empty($_POST['�ҏW�ԍ�']) && empty($_POST['pasuhen'])){
		echo "�ҏW�Ώ۔ԍ��ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="�ҏW�Ώ۔ԍ��ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['�ҏW�ԍ�'])){
		echo "�ҏW�Ώ۔ԍ��������͂ł��B";
		$_SESSION[message]="�ҏW�Ώ۔ԍ��������͂ł��B";
	}elseif(empty($_POST['pasuhen'])){
		echo "�p�X���[�h�������͂ł��B";
		$_SESSION[message]="�p�X���[�h�������͂ł��B";
	}

	$henban=$_POST['�ҏW�ԍ�'];
	$henpas=$_POST['pasuhen'];

	if(!empty($_POST['�ҏW�ԍ�'])){
		//�f�[�^�x�[�X�ɐڑ�
		$pdo=new PDO($dsn,$user,$password);
		$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p

		//���͂����ԍ��ƈ�v����f�[�^�̃p�X���[�h���󂯎��
		$pa="SELECT com_pass FROM com_tb where com_id='$henban'";
		$par=$pdo->query($pa);
		$parr=$par->fetchColumn();
		if($parr==FALSE){
			echo "���͂����ԍ��ɊY�����铊�e��������܂���ł����B";
			$_SESSION[message2]="���͂����ԍ��ɊY�����铊�e��������܂���ł����B";
		}
		if(!empty($_POST['�ҏW�ԍ�']) && !empty($_POST['pasuhen'])){ 

			//���͂����p�X���[�h�ƈ�v���邩�m�F
			if($parr==$henpas){
				$parrr=$parr;
				$na="SELECT com_name FROM com_tb where com_id='$henban'";
				$co="SELECT com_comment FROM com_tb where com_id='$henban'";

				$nar=$pdo->query($na);
				$cor=$pdo->query($co);

				$narr=$nar->fetchColumn();
				$corr=$cor->fetchColumn();

				//�ҏW����O�̊e�f�[�^��\��
				echo "���e���e�̕ҏW�����Ă��������B"."<br/>\n"."�y�ҏW�Ώہz"."<br/>\n"."$henban"." "."���O�F"."$narr"." "."�R�����g�F"."$corr";
				$_SESSION[message]="���e���e�̕ҏW�����Ă��������B"."<br/>\n"."�y�ҏW�Ώہz"."<br/>\n"."$henban"." "."���O�F"."$narr"." "."�R�����g�F"."$corr";
			}
			else{
				echo "�p�X���[�h���Ⴂ�܂��B";
				$_SESSION[message]="�p�X���[�h���Ⴂ�܂��B";
			}
//�ڑ��I��
$pdo=null;
		}
	}
}

/*----------���R�[�h��ҏW����----------*/
if(isset($_POST['�ҏW����'])){
	if(empty($_POST['�ҏW���O']) && empty($_POST['�ҏW�R�����g']) && empty($_POST['�ҏW�p�X���A�h'])){
		echo "���O�ƃR�����g�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="���O�ƃR�����g�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['�ҏW���O']) && empty($_POST['�ҏW�R�����g'])){
		echo "���O�ƃR�����g�������͂ł��B";
		$_SESSION[message]="���O�ƃR�����g�������͂ł��B";
	}elseif(empty($_POST['�ҏW�R�����g']) && empty($_POST['�ҏW�p�X���A�h'])){
		echo "�R�����g�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="�R�����g�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['�ҏW���O']) && empty($_POST['�ҏW�p�X���A�h'])){
		echo "���O�ƃp�X���[�h�������͂ł��B";
		$_SESSION[message]="���O�ƃp�X���[�h�������͂ł��B";
	}elseif(empty($_POST['�ҏW���O'])){
		echo "���O�������͂ł��B";
		$_SESSION[message]="���O�������͂ł��B";
	}elseif(empty($_POST['�ҏW�R�����g'])){
		echo "�R�����g�������͂ł��B";
		$_SESSION[message]="�R�����g�������͂ł��B";
	}elseif(empty($_POST['�ҏW�p�X���A�h'])){
		echo "�p�X���[�h�������͂ł��B";
		$_SESSION[message]="�p�X���[�h�������͂ł��B";
	}

if(!empty($_POST['�ҏW���O']) && !empty($_POST['�ҏW�R�����g']) && !empty($_POST['�ҏW�p�X���A�h'])){
//�f�[�^�x�[�X�ɐڑ�
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES utf8'); //���������΍��p

//�����ɏ������L��
//�u�ҏW����ԍ��̎w��v�Ŏw�肵���ԍ����󂯎��
$id=$_POST['�����ւ�'];
//�e���͍��ڂ�ϐ��Ɋi�[
$nm=$_POST['�ҏW���O'];
$kome=$_POST['�ҏW�R�����g'];
$pasu=$_POST['�ҏW�p�X���A�h'];

$nm=mb_convert_encoding($nm,"UTF-8","sjis");
$kome=mb_convert_encoding($kome,"UTF-8","sjis");

//�ҏW����
$sql="update com_tb set com_name='$nm',com_comment='$kome',com_pass='$pasu' where com_id=$id";
$result=$pdo->query($sql);

//�ڑ��I��
$pdo=null;
}
}

?>

<html>
<body>

<?php
/*----------�f�[�^��\������----------*/
//�f�[�^�x�[�X�ɐڑ�
$pdo=new PDO($dsn,$user,$password);
$stmt=$pdo->query('SET NAMES sjis'); //���������΍��p
?>

<!---�����ɏ������L��--->
<!---�f�[�^�\��--->
<!---�R�����g�̕\��--->
<?php echo"<hr>"; ?>
<!---�S�ẴR�����g���󂯎��--->
<?php $sql='SELECT * FROM com_tb ORDER BY com_id'; ?>
<?php $results=$pdo->query($sql); ?>
<?php foreach ($results as $row): ?>
<!---�e�J�����̃f�[�^���q���ĕ\��--->
<!---$row�̒��ɂ̓e�[�u���̃J������������--->
<?php	echo $row['com_id'].' ';
	echo $row['com_name'].' ';
	echo $row['com_comment'].' ';
	echo $row['com_time'].'<br>';
	//�R�����g�̓��e�ԍ���ϐ��Ɋi�[
	$id=$row['com_id'];
	//DB����擾���ĕ\������D
	//�S�Ẳ摜�E����̃f�[�^���󂯎��
	$sql = "SELECT * FROM media_tb ORDER BY media_id";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
?>
	<?php while ($row = $stmt -> fetch(PDO::FETCH_ASSOC)): ?>
		<!---�R�����g�̓��e�ԍ��ƈ�v����ԍ��̉摜�E������w��--->
		<?php if($row["media_id"]==$id): ?>
		<!---����Ɖ摜�ŏꍇ����--->
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
<!---�ڑ��I��--->
<?php $pdo=null; ?>
</body>
</html>

<?php
/*---���b�Z�[�W�̕\��---*/
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
<!--�V�K����-->
<fieldset class="sample1">
<legend><strong>�V�K����</strong></legend>
	���O�@�@�@�@�F<input class="sample1" type="text" name="���O" value=<?php echo $_SESSION["user_name"]; ?>><br/>
	�R�����g�@�@�F<input class="sample1-2" type="text" name="�R�����g"><br/>
	�p�X���[�h�@�F<input class="sample1" type="password" name="�p�X���A�h" value=<?php echo $_SESSION["user_pass"]; ?>><br/>
	<label>�摜/����A�b�v���[�h</label>
	<input type="file" name="upfile"><br>
	���摜��jpeg�����Cpng�����Cgif�����ɑΉ����Ă��܂��D�����mp4�����̂ݑΉ����Ă��܂��D<br>
	<input type="submit" name="uplode" value="�V�K����">
</fieldset>
<!--�폜-->
<fieldset class="sample1">
<legend><strong>�폜</strong></legend>
	�폜�Ώ۔ԍ��F<input class="sample2" type="text" name="�폜"/><br/>
	�p�X���[�h�@�F<input class="sample2" type="text" name="pasusaku"><br/>
	<input type="submit" name="�폜����" value="�폜"><br/>
</fieldset>
<fieldset class="sample1">
<legend><strong>�ҏW</strong></legend>
<!--�ҏW�ԍ��w��-->
	�ҏW�Ώ۔ԍ��F<input class="sample3" type="text" name="�ҏW�ԍ�"><br/>
	�p�X���[�h�@�F<input class="sample3" type="text" name="pasuhen"><br/>
	<input type="submit" name="�ҏW�ԍ��w��{�^��" value="�ҏW����ԍ����w��"><br/>	
	<input type="hidden" name="�����ւ�" value="<?php echo $henban; ?>"/><br>
<!--�ҏW-->
	���O�@�@�@�@�F<input class="sample4" type="text" name="�ҏW���O" value="<?php echo $narr; ?>"/><br/>
	�R�����g�@�@�F<input class="sample4-2" type="text" name="�ҏW�R�����g" value="<?php echo $corr; ?>"/><br/>
	�p�X���[�h�@�F<input class="sample4" type="password" name="�ҏW�p�X���A�h" value="<?php echo $parrr; ?>"/><br/>
	<input type="submit" name="�ҏW����" value="�ҏW����"><br/>
<!--�X�V���A�����ꏊ�ɔ��-->
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
<!-- jquery�ǂݍ��� -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<!-- �X�N���[�� -->
<script type="text/javascript">

<!--���̈ʒu�Ɉړ�-->
$('form').submit(function(){
	var scroll_top = $(window).scrollTop();  <!--���M���̈ʒu�����擾-->
	$('input.st',this).prop('value',scroll_top); <!--�B���t�B�[���h�Ɉʒu����ݒ�-->
});

window.onload = function(){
<!--���[�h���ɉB���t�B�[���h����擾�����l�ňʒu���X�N���[��-->
  $(window).scrollTop(<?php echo @$_REQUEST['scroll_top']; ?>);
}

</script>
</head>
</form>
</body>
</html>
