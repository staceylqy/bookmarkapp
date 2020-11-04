<?php
//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET['id'];
?>

<?php
require_once("funcs.php");
$pdo = db_conn();


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table WHERE id=" . $id);
$status = $stmt->execute();


//３．データ表示
$view = "";
if ($status == false) {
    sql_error($status);
} else {

    $result = $stmt->fetch();

}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>編集</title>
    <style>div{padding:10px; }</style>
    </head>
<body>
    <div class ="title" style="background-color: #463333; height:80px;margin-bottom:20px;margin-left:10px;color:white;">
        <h1 class="home_title">書類の管理画面</h1>
    </div>

    <div class="contact-form">
        <h2>編集</h2>
        <form action="update.php" method="post" style="border:1px solid #463333;width:23%;margin-bottom:20px;padding-left:10px;padding-bottom:10px;">
                <input type="hidden" name="id" value="<?php if (!empty($result['id'])) echo(htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'));?>">
            <p>
                <label>書籍名：</label>
                <input type="text" name="name" value="<?php if (!empty($result['name'])) echo(htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8'));?>">
            </p>
            <p>
                <label>書籍分類:</label>
                <select name = "category">
                <?php 
                $types = array('文学', '科学', '漫画', '語学', '仕事', 'その他');
                ?>
                <option><?php if (!empty($result['category'])) echo(htmlspecialchars($result['category'], ENT_QUOTES, 'UTF-8'));?></option>
                <?php
                foreach($types as $type){
                    echo "<option value='$type'>$type</option>";
                }
                ?>
                </select>

            </p>
            <p>
                <label>書籍URL：</label>
                <input type="text" name="url" value="<?php if (!empty($result['url'])) echo(htmlspecialchars($result['url'], ENT_QUOTES, 'UTF-8'));?>">
            </p>
            
            <p>
                <label>書籍コメント:</label>
                <textArea type="text" name="comment" rows="4" cols="40"><?php if (!empty($result['comment'])) echo(htmlspecialchars($result['comment'], ENT_QUOTES, 'UTF-8'));?></textArea>
            </p>
            <input type="submit" value="編集する" style="border:1px solid #463333;background-color: #835858; color:white;cursor:pointer;">

        </form>
    </div>
        <a href="index.php">データ一覧へ</a>
</body>
</html>