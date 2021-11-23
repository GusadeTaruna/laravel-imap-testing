<html>
    <head>

    </head>
    <body>
        <form action="{{route('connect')}}" method="post">
            @csrf
            <label>Email </label>
            <input type="email" name="email"/>
            <label>Password</label>
            <input type="password" name="password"/>
            <input type="submit" value="connect"/>
        </form>
    </body>
</html>