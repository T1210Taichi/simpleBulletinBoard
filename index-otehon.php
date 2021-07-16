<!-- -->

<?php


$errors = [];

if($_POST){
	$id = null;
	$name = $_POST["name"];
	$contents = $_POST["contents"];
	date_default_timezone_set('Asia/Tokyo');
	$created_at = date("Y-m-d H:i:s");

	if(!$name){
        $errors[] .= "名前を入力してください";
    }
    if(!$contents){
        $errors[] .= "投稿内容を入力してください";
    }
	if(!$errors){
		//DB接続情報を設定します。
		try{
		$pdo = new PDO(
			"mysql:dbname=simpleBulletinBoard;host=localhost","root","simatako0606",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
		);
		}catch(PDOException $e){
			echo "Erro" , $e->getMessage();
		}

		//SQLを実行。
		$regist = $pdo->prepare("INSERT INTO post(id, name, contents, created_at) VALUES (:id,:name,:contents,:created_at)");
		$regist->bindParam(":id", $id);
		$regist->bindParam(":name", $name);
		$regist->bindParam(":contents", $contents);
		$regist->bindParam(":created_at", $created_at);
		$regist->execute();
	}
}

//DB接続情報を設定します
try{
	$pdo = new PDO(
		"mysql:dbname=simpleBulletinBoard;host=localhost","root","simatako0606",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`")
	);
}catch(PDOException $e){
	echo "Erro" , $e->getMessage();
}
//SQLを実行。
//最新の投稿２０件までを新しい順に表示
$regist = $pdo->prepare("SELECT * FROM post order by created_at DESC limit 20");
$regist->execute();

?>

<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>シンプル掲示板</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<h1>掲示板</h1>
<section>
	<h2>新規投稿</h2>
	<div id="error"><?php foreach($errors as $error){echo $error.'<br>';}?></div>
	<form action="index.php" method="post">
		名前 : <input type="text" name ="name" value=""><br>
		投稿内容 : <input type="text" name="contents" value=""><br>
		<button type="submit">投稿</button>
	</form>
</section>

<section>
	<h2>投稿内容一覧</h2>
		<?php foreach($regist as $loop):?>
			<div>No：<?php echo $loop['id']?></div>
			<div>名前：<?php echo $loop['name']?></div>
			<div>投稿内容：<?php echo $loop['contents']?></div>
			<div>投稿時間 : <?php echo $loop['created_at']?></div>
			<div>------------------------------------------</div>
		<?php endforeach;?>
	
</section>
