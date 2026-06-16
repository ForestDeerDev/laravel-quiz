<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="{{ URL::asset('css/quiz.css') }}">
    <title>在线答题</title>
</head>
<body>
    <h1>在线答题</h1>
    <div class="box">
        <h2 id="test_status">第{{ $qid }}题</h2>
        <div id="test">
            <form method="post" action="{{ !$last ? '/quiz/next/' . $qid : '/quiz/submit' }}">
                @csrf
                <h3>{{ $stem }}</h3>
                @foreach($options as $key => $value)
                    <input type="radio" name="choices" value="{{ $key }}" required> {{ $value }}<br>
                @endforeach
                <br>
                @if(!$last)
                    <button type="submit">下一题</button>
                @else
                    <button type="submit">提交</button>
                @endif
            </form>
        </div>
    </div>
</body>
</html>