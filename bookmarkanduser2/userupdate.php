<?php
//PHP:コード記述/修正の流れ
//1. insert.phpの処理をマルっとコピー。
//   POSTデータ受信 → DB接続 → SQL実行 → 前ページへ戻る
//2. $id = POST["id"]を追加
//3. SQL修正
//   "UPDATE テーブル名 SET 変更したいカラムを並べる WHERE 条件"
//   bindValueにも「id」の項目を追加
//4. header関数"Location"を「select.php」に変更

// require_once('funcs.php');
include('funcs.php');

//1. POSTデータ取得
$id    = $_POST["id"];
$username = $_POST["username"];
$idnumber = $_POST["idnumber"];
$life = $_POST['life'];


//2. DB接続します
$pdo = user_conn();

//３．データ登録SQL作成
//$stmt = $pdo->prepare("UPDATE gs_user_table SET name = '山田', lid = '99', lpw = '99', kanri_flg = '一般管理者', life_flg = '入社' WHERE id = :id ;");
$stmt = $pdo->prepare("UPDATE gs_user_table SET name = :name, lid = :lid, life_flg = :life_flg WHERE id = :id ;");
$stmt->bindValue(':name', h($username), PDO::PARAM_STR);      //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', h($idnumber), PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':life_flg', h($life), PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':id', h($id), PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行


//４．データ登録処理後
if($status==false){
    //*** function化する！*****************
    sql_error($stmt);
    // $error = $stmt->errorInfo();
    // exit("SQLError:".$error[2]);
}else{
    //*** function化する！*****************
    redirect('userselect.php');
    // header("Location: index.php");
    // exit();
}
?>
