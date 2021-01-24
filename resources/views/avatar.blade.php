<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    @php

    @endphp
    @dump($child->avatar_config)
    <img src="/avatar/{{$child->id}}.svg" alt="">
</body>
</html>