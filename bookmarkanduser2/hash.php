<?php
    //パスワード作る場合
    //ユーザー管理画面の登録する前に以下処理が必要になる
    $pw = password_hash("test", PASSWORD_DEFAULT);
    echo $pw;

?>