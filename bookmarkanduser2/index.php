<?php
//1.  DB接続します
try {
  //ID MAMP ='root'
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=bookmark;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DB接続エラー:'.$e->getMessage());
}

//２．データ取得SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_bm_table");
$status = $stmt->execute();

//３．データ表示
if ($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ登録</title>
  <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
  <script src="js/jquery-2.1.3.min.js"></script>
  <link rel="stylesheet" href="css/bookmark.css">
  <style>div{padding:10px; }</style>

</head>
<body>
<div class ="title" style="background-color: #463333; height:80px;margin-bottom:40px;margin-left:10px;color:white;">
  <h1 class="home_title">書類の管理画面</h1>
</div>

<!-- データ登録 -->
<div class="dataregister">
<form id="dataregister" method="post" action="insert.php" class="dataregister">
   <fieldset style="border:1px solid #463333;width:23%;margin-bottom:20px;">
    <h2>データ登録</h2>
     <label >書籍名：<input type="text" name="name"></label><br>
     <label>書籍分類:
   
     
        <select name = "category" >
        <?php 
          $types = array('文学', '科学', '漫画', '語学', '仕事', 'その他');
        ?>
          <option value = '未選択'>選択してください</option>
          <?php
          foreach($types as $type){
            echo "<option value='$type'>$type</option>";
          }
          ?>
        </select>
    </label><br>
    
    <label>書籍URL：<input type="text" name="url"></label><br>
     <label>書籍コメント:<br><textArea type="text" name="comment" rows="4" cols="40"></textArea></label><br>
     <input type="submit" value="登録" style="border:1px solid #463333;background-color: #835858; color:white;cursor:pointer;">
    </fieldset>
 
</form>
</div>
<!-- データ表示 -->
<h2 class="datalist" style="padding-left: 30px;">データ一覧</h2>
        <?php
            // 各分類の冊数（パイチャートの部分）
            $cone=0;
            $ctwo=0;
            $cthree=0;
            $cfour=0;
            $cfive=0;
            $csix=0;

            if ($status == false) {
              sql_error($status);
            } else {

            echo '<table class="table" style="text-align: center; border: 1px solid black;margin:0px 10px;margin-bottom:50px;width:90%;">';
              echo '<tr style="background-color:#835858; color:white;">';
              echo '<th>登録日付</th><th style="border: 1px solid black;">書籍名</th><th>分類</th><th>URL</th><th>コメント</th><th></th>';
              echo '</tr>';
              while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){
             
                echo '<tr >';
                echo '<td class="display" style="background-color:#ebd4d4;"width:20%>' . $result['indate'] . '</td>';
                echo '<td class="display" style="background-color:#ebd4d4;width:15%">' . $result['name'] . '</td>';
                echo '<td class="display" style="background-color:#ebd4d4;width:10%">' . $result['category'] . '</td>';
                echo '<td class="display" style="background-color:#ebd4d4;width:20%">' . $result['url'] . '</td>';
                echo '<td class="display" style="background-color:#ebd4d4;width:20%">' . $result['comment'] . '</td>';
                echo '<td class="display" style="background-color:#ebd4d4;width:15%">';
                echo "<button style='background-color:#d9adad;border:none;' ><a style='text-decoration:none;color:white;' href=edit.php?id=" . $result['id'] . ">編集</a></button>\n";
                echo '<button style="background-color:#d9adad;border:none;" >';
                echo "<a class='deletebutton' style='text-decoration:none;color:white;' href=delete.php?id=" . $result["id"] . " οnclick='javascript:return warning()'>削除</a>";
                echo '</button>';
                // echo "<a href=edit.php?id=" . $result['id'] . ">編集</a>\n";
                // echo "<a href=delete.php?id=" . $result["id"] . ">削除</a>\n";
                echo '</td>';
                echo '</tr>';


                // 各分類の冊数（パイチャートの部分）
                if(strpos($result['category'], "文学")!== false){
                  $cone += 1;
                  
                }else if(strpos($result['category'], "科学")!== false){
                  $ctwo += 1;
                }else if(strpos($result['category'], "漫画")!== false){
                  $cthree += 1;
                }else if(strpos($result['category'], "語学")!== false){
                  $cfour += 1;
                }else if(strpos($result['category'], "仕事")!== false){
                  $cfive += 1;
                }else if(strpos($result['category'], "その他")!== false){
                  $csix += 1;
                }
            
            }
            echo "</table>\n";
          }
        ?>

<!-- チャート -->
<div style="width:100%;margin-left:20px;">
  <div id="piechart" style="width:700px;height:400px;"></div>
  <div id="columnchart_material" style="width: 600px; height: 500px;"></div>
</div>


</body>
<!-- Piechart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      
       // 各分類の冊数（パイチャートの部分）
       let a = parseInt("<?=$cone;?>");
       let b = parseInt("<?=$ctwo;?>");
       let c = parseInt("<?=$cthree;?>");
       let d = parseInt("<?=$cfour;?>");
       let e = parseInt("<?=$cfive;?>");
       let f =parseInt("<?=$csix;?>");
       
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['書類分類' , '冊数'],
            ['文学' , a],
            ['科学' , b],
            ['漫画' ,c],
            ['語学' , d],
            ['仕事' ,e],
            ['その他' ,f]
        ]);

       

        var options = {
          title: '登録した書類分類'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>

<!-- Bar chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([

          ['書類分類', '冊数'],
          ['文学', a],
          ['科学', b],
          ['漫画', c],
          ['語学', d],
          ['仕事', e],
          ['その他', f]
        ]);

        var options = {
          chart: {
            
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }

      
    </script>

<script>
$(function() {

  $(".deletebutton").on("click",function(){
    
    var r = confirm("削除してよろしいでしょうか。");
    if (r == true) {
      return true;
    } else {
      return false;
    }
 
   
 });
})
</script>


</html>

