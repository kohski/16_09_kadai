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

//2. DB接続します
$pdo = db_con();

// //３．データ登録SQL作成
$sql="INSERT INTO gs_bm_table(id,name,URL,comment,register_date) VALUES(NULL,:a1,:a2,:a3,sysdate())";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $url, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

// //４．データ登録処理後
if($status==false){
  //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
  $error = $stmt->errorInfo();
  exit("sqlError:".$error[2]);
}else{
  //５．index.phpへリダイレクト
  header("Location: index.php"); //ここの半角スペースは必須！！！！
}
?>
