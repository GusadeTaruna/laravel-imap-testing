<html>



<head></head>
<body>
    
            
        {{-- echo $message->getSubject().'<br />';
        echo 'Attachments: '.$message->getAttachments()->count().'<br />';
        echo $message->getHTMLBody(); --}}

<table width="100%">
    <form action="{{route('search')}}" method="post">
        @csrf
        <tr>
            <td> Search</td>
        </tr>
        <tr>
            <td> <input name="search" required></td>
        </tr>
        <tr>
            <td> <input type="submit" value="Search"></td>
        </tr>
    </form>
</table>

    <table border="2" width="100%">
        @foreach($messages as $key=> $message)
            <tr>
                {{-- @if($key==10)
                {{dd($message->getHeader())}}
                @endif --}}
                <td>{{$key+1}}</td>
                <td>{{$message->getSubject()}}</td>
            </tr>
            <tr>
                <td colspan="2">{{$message->getTextBody()}}</td>
            </tr>
            <tr>
                <td colspan="2">{{$message->getDate()}}</td>
            </tr>
            <tr><td colspan="2" style="padding-bottom: 2em;">===========End==========</td></tr>
        @endforeach
    </table>
</body>
</html>