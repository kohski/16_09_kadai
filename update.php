<?php
session_start();
include("functions.php");
chk_ssid();

if(
  !isset($_POST["name"])||$_POST["name"]==""||
  !isset($_POST["url"])||$_POST["url"]==""||
  !isset($_POST["comment"])||$_POST["comment"]==""
){
  exit('ParamError');
}

//1. POSTデータ取得
//$name = filter_input( INPUT_GET, ","name" ); //こういうのもあるよ
//$email = filter_input( INPUT_POST, "email" ); //こういうのもあるよ

$name = $_POST["name"];
$url = $_POST["url"];
$comment = $_POST["comment"];
$id = $_POST["id"];

//2. DB接続します
try {
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('DbConnectError:'.$e->getMessage());
}

// //３．データ登録SQL作成
$sql="UPDATE gs_bm_table SET name=:a1,URL=:a2,comment=:a3 WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

// //４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: select.php"); //ここの半角スペースは必須！！！！
}
?>
