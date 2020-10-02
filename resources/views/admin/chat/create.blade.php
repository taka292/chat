{{-- <!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>チャット</title>
</head>

<body>



    <h1>チャット</h1>







    <form method="post" action="chat.php">
        名前　　　　<input type="text" name="name">
        メッセージ　<input type="text" name="message">

        <button name="send" type="submit">送信</button>

        チャット履歴
    </form>



</body> --}}

{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'ニュースの新規作成'を埋め込む --}}
@section('title', 'チャット')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>chat</h2>
        </div>
    </div>
    <form method="post" action="chat.php">
        名前　　　　<input type="text" name="name">
        メッセージ　<input type="text" name="message">

        <button name="send" type="submit">送信</button>

        チャット履歴
    </form>

    <section>
        <?php
        // DBからデータ(投稿内容)を取得
        $stmt = select(); foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                    // 投稿内容を表示
                    echo $message['time'],"：　",$message['name'],"：",$message['message'];
                    echo nl2br("\n");
                    }

                // 投稿内容を登録
                if(isset($_POST["send"])) {
                    insert();
                    // 投稿した内容を表示
                    $stmt = select_new();
                    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
                        echo $message['time'],"：　",$message['name'],"：",$message['message'];
                        echo nl2br("\n");
                    }
                }

                // DB接続
                function connectDB() {
                    $dbh = new PDO('mysql:host=localhost;dbname=message','user','IkedaTakao1');
                    return $dbh;
                }

                // DBから投稿内容を取得
                function select() {
                    $dbh = connectDB();
                    $sql = "SELECT * FROM message ORDER BY time";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    return $stmt;
                }

                // DBから投稿内容を取得(最新の1件)
                function select_new() {
                    $dbh = connectDB();
                    $sql = "SELECT * FROM message ORDER BY time desc limit 1";
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    return $stmt;
                }

                // DBから投稿内容を登録
                function insert() {
                    $dbh = connectDB();
                    $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
                    $stmt = $dbh->prepare($sql);
                    $params = array(':name'=>$_POST['name'], ':message'=>$_POST['message']);
                    $stmt->execute($params);
                }
            ?>
    </section>
</div>
@endsection
