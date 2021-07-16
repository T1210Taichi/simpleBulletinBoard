
<!-- -->

<!DOCTYPE html>
<meta charset="UTF-8">
<title>シンプル掲示板</title>
<h1>シンプル掲示板</h1>
<section>
	<h2>投稿完了</h2>
	<button onClick="location.href='index.php'">戻る</button>
</section>

<!-- aa -->
<?php
$id = null;
$name = $_POST["name"];
$contents = $_POST["contents"];
date_default_timezone_set('Asia/Tokyo');
$created_at = date("Y-m-d H:i:s");


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

?>
<!--a -->