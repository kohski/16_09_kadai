<?php
session_start();
include("functions.php");
chk_ssid();

//1.  DB接続します
$pdo = db_con();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
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
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
    $view .= '<tr>';
    $view .= '<td>'.$result["name"].'</td>';
    $view .= '<td>'.$result["URL"].'</td>';
    $view .= '<td>'.$result["comment"].'</td>';
    $view .= '<td>'.$result["register_date"].'</td>';
    $view .= '<td><a href="detail.php?id='.$result["id"].'">[更新]</a></td>';
    $view .= '<td><a href="delete.php?id='.$result["id"].'">[削除]</a></td>';
    $view .= '</tr>';
  }
}
?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録</a>
      <a class="navbar-brand" href="logout.php">LOGOUT</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div>
    <div class="container jumbotron">
    <table>
      <tr>
        <td>書籍名</td>
        <td>URL</td>
        <td>コメント</td>
        <td>登録日付</td>
        <td>更新</td>
        <td>削除</td>
      </tr>
      <?php echo $view?>
    </table>
    <a href="index.php">登録</a>
  </div>
</div>
<!-- Main[End] -->

</body>
</html>
