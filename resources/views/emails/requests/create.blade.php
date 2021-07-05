<!DOCTYPE html>
<html>
  <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <style type="text/css">
        body {margin: 0; padding: 0; min-width: 100%!important;}
        .content {width: 100%; max-width: 600px;}  
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
        </style>
    </head>
    <body>
        <h2>&nbspTạo mới request thành công</h2>
        <table>
            <tr>
                <td>Name: </td>
                <td>{{$mail['requestName']}}</td>
            </tr>
            <tr>
                <td>Content: </td>
                <td>{{$mail['content']}}</td>
            </tr>
            <tr>
                <td>Author: </td>
                <td>{{$mail['authorName']}}</td>
            </tr>
            <tr>
                <td>Assign: </td>
                <td>{{$mail['assignName']}}</td>
            </tr>
            <tr>
                <td>Due-date: </td>
                <td>{{$mail['dueDate']}}</td>
            </tr>
        </table>
</div>
</body>
</html>
