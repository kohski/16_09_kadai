<?php
session_start();
include("functions.php");
chk_ssid();

$id=$_GET["id"];

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=:id");
$stmt -> bindValue(":id",$id,PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>ブックマーク</legend>
     <label>書籍名：<input type="text" name="name" value="<?=$result['name']?>"></label><br>
     <label>書籍URL：<input type="text" name="url" value="<?=$result['URL']?>"></label><br>
     <label><textArea name="comment" rows="4" cols="40"><?=$result['comment']?></textArea></label><br>
     <input type="submit" value="変更">
     <input type="hidden" name="id" value="<?=$result['id']?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>
