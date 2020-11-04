<?php
//【重要】
//insert.phpを修正（関数化）してからselect.phpを開く！！
require_once("funcs.php");
$pdo = user_conn();


//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table");
$status = $stmt->execute();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザーリスト（一般管理者画面）</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="css/bookmark.css">
  <style>div{padding:10px; }</style>
  <style>
  body {
    font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    
    line-height: 1;
    color: #414141;

   }

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }
ol, ul { list-style: none; }

blockquote, q { quotes: none; }
blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
strong, b { font-weight: bold; }
em, i { font-style: italic; }

table { border-collapse: collapse; border-spacing: 0; }
img { border: 0; max-width: 100%; }

/* page structure */
.w {
  display: block;
  width: 650px;
  margin: 0 auto;
  font-size: 62.5%;
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

.page {
  display: block;
  background: #fff;
  padding: 15px 0;
  -webkit-box-shadow: 0 2px 4px rgba(0,0,0,0.4);
  -moz-box-shadow: 0 2px 4px rgba(0,0,0,0.4);
}

/** cart table **/
.cart {
  display: block;
  border-collapse: collapse;
  margin: 0;
  width: 100%;
  font-size: 1.2em;
  color: #444;
}
.cart thead th {
  padding: 8px 0;
  font-weight: bold;
}

.cart thead th.first {
  width: 175px;
}
.cart thead th.second {
  width: 80px;
}
.cart thead th.third {
  width: 130px;
}
.cart thead th.fourth {
  width: 130px;
}
.cart thead th.fifth {
  width: 100px;
}

.cart tbody td {
  text-align: center;
  margin-top: 4px;
}

tr.productitm {
  height: 65px;
  line-height: 65px;
  border-bottom: 1px solid #d7dbe0;
}


.cart tbody td img.thumb {
  vertical-align: bottom;
  border: 1px solid #ddd;
  margin-bottom: 4px;
}

.qtyinput {
  width: 33px;
  height: 22px;
  border: 1px solid #a3b8d3;
  background: #dae4eb;
  color: #616161;
  text-align: center;
}

.remove {
  /* http://findicons.com/icon/261449/trash_can?id=397422 */
  cursor: pointer;
  position: relative;
  right: 12px;
  top: 5px;
}

/* tag */
body {
  font-family: 'Nunito', sans-serif;
  color: #222;
}

* {
  transition: all .65s ease;
  box-sizing: border-box;
  
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

<div class ="title" style="background-color: #1f6f8b; height:90px;margin-bottom:40px;margin-left:10px;color:white;">
  <h1 class="home_title" style="padding-left: 30px;">ユーザーリスト(スーパー管理者画面)</h1>
  <nav class="main-nav">
    <ul>
    <li class="list"><a class="tab" href="index.php">書類管理</a></li>
    <li class="list"><a class="tab" href="logout.php">ログアウト</a></li>
  </ul>
</nav>
</div>

<!-- 説明 -->
<div class="explain" style="border:1px solid #1f6f8b;text-align:center;width:35%;margin:auto;margin-top:80px;">
  <h3>一般管理者画面利用説明</h3>
  <ul>
    <li>画面に一般管理者だけのユーザーリストが表示されます</li>
    <li>ユーザー名前、ユーザーID、入社状況が編集できます</li>
  </ul>
</div>


<!-- データ表示 -->
<div class="datalist" style="padding-left: 30px;"></div>
        <?php
    
            if ($status == false) {
              sql_error($status);
            } else {

              while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){

                // 一般管理者のユーザーリスト管理画面に一般管理者だけのユーザーリストが表示されます
                if($result['kanri_flg']=="一般管理者"){
                  

                echo '<div class="w">';
                echo '<div class="title"></div>';
                echo '<div class="page"><table class="cart">';
                echo '<thead><tr>';
                echo '<th class="first">管理者タイプ</th><th class="second">お名前</th><th class="third">ID</th><th class="fourth">入社状況</th><th class="fifth">&nbsp;</th>' ; 
                echo '</tr></thead>';
                echo '<tbody>';
                echo '<tr class="productitm">';      
                echo '<td>' . $result['kanri_flg'] . '</td>';
                echo '<td>' . $result['name'] . '</td>';
                echo '<td>' . $result['lid'] . '</td>';
                echo '<td>' . $result['life_flg'] . '</td>';   
                echo '<td>';
                echo "<a href=useredit.php?id=" . $result['id'] . ">編集</a>\n";
                echo '</td>';
                echo '</tr>';  
                echo '</tbody>';
                echo '</table>';       
                      
                echo '</div>';
                echo '</div><br>';
          
                }
            
            }

          }
        ?>

</body>

</html>

