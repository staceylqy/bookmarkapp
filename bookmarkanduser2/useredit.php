<?php
require_once("funcs.php");

//１．PHP
//select.phpのPHPコードをマルっとコピーしてきます。
//※SQLとデータ取得の箇所を修正します。
$id = $_GET['id'];
$pdo = user_conn();
?>

<?php
//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=" . $id);
$status = $stmt->execute();


//３．データ表示
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
    <title>ユーザーリスト編集</title>
    <style>div{padding:10px; }</style>
    <style>
        /* tag */

body {
  font-family: 'Nunito', sans-serif;
  color: #222;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  line-height: 1;
}

* {
  transition: all .65s ease;
  box-sizing: border-box;
  
}

.title {
  display: block;
  width: 100%;
  background: #b2deec;
  padding: 10px 0;
  -webkit-border-top-right-radius: 6px;
  -webkit-border-top-left-radius: 6px;
  -moz-border-radius-topright: 6px;
  -moz-border-radius-topleft: 6px;
  border-top-right-radius: 6px;
  border-top-left-radius: 6px;
}

.main-nav {
  background:  #51adcf;
  color: white;
}
.tab{
  color: #ffffff;
  padding: 20px 45px;
  display: flex;
  text-transform: uppercase;
  text-decoration: none;
}

.tab:hover{
  background: lighten(#F7EE1A, 25%);
  color: lighten(#1A577F, 25%);
}
.tab:focus{
  background: lighten(#F7EE1A, 25%);
  color: lighten(#1A577F, 25%);
} 

.list {
    list-style: none;
    margin: 0;
    padding: 0;
  }
.main-nav ul {
    display: flex;
    align-items: center;
    flex-direction: row;
    justify-content: center;
    width: 100%;
    list-style: none;
    margin: 0;
    padding: 0
  }
  </style>

</head>
<body>
    <div class ="title" style="background-color: #1f6f8b; height:90px;margin-bottom:100px;margin-left:10px;color:white;">
        <h1 class="home_title" style="padding-left: 30px;">ユーザーリストの編集画面</h1>
        <nav class="main-nav">
        <ul>
            <li class="list"><a class="tab" href="userselect.php">ユーザーリスト</a></li>
            <li class="list"><a class="tab" href="logout.php">ログアウト</a></li>
        </ul>
    </nav>
    </div>

    <div class="contact-form">
        <form action="userupdate.php" method="post" style="border:1px solid #463333;width:23%;margin-bottom:20px;padding-left:10px;padding-bottom:10px;">
                <input type="hidden" name="id" value="<?php if (!empty($result['id'])) echo(htmlspecialchars($result['id'], ENT_QUOTES, 'UTF-8'));?>">
            <p>
                <label>ユーザー名前：</label>
                <input type="text" name="username" value="<?php if (!empty($result['name'])) echo(htmlspecialchars($result['name'], ENT_QUOTES, 'UTF-8'));?>">
            </p>
    
            <p>
                <label>ユーザーID：</label>
                <input type="text" name="idnumber" value="<?php if (!empty($result['lid'])) echo(htmlspecialchars($result['lid'], ENT_QUOTES, 'UTF-8'));?>">
            </p>
            
            <p>
                <label>入社状況：</label><br><br>
                <select name = "life">
                <?php 
                $lives = array('入社', '退社');
                ?>
                <option><?php if (!empty($result['life_flg'])) echo(htmlspecialchars($result['life_flg'], ENT_QUOTES, 'UTF-8'));?></option>
                <?php
                foreach($lives as $life){
                    echo "<option value='$life'>$life</option>";
                }
                ?>
                </select>
            </p>
            
            <input type="submit" value="編集する" style="border:1px solid #51adcf;background-color: #51adcf; color:white;cursor:pointer;">

        </form>
    </div>
</body>
</html>