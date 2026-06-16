<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="{{ URL::asset('css/quiz.css') }}">
    <title>答题结果</title>
</head>
<body>
    <h1>在线答题</h1>
    <div class="box">
        <h2 id="test_status">答题结束</h2>
        <div id="test">
            共答对{{ $right_num }}题，获得{{ $score }}分
        </div>
        <br>
        <button type="button" onclick="window.location='/'">重做</button>
    </div>
</body>
</html>