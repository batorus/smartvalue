<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>
    <body>
        <ul>
            <li><a href="{{ $baseurl }}/about">About</a></li>
            <li><a href="{{$baseurl}}/content">Content</a></li>
        </ul>
        
        @yield("content")
    </body>
</html>




