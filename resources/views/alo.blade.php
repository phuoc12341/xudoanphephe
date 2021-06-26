<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid m-5 ">
        <div class="container">
            <div class="row">
                <div class="col-sm">
                    <form method="POST" action="/alo" >
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Nhập bạch văn vào đây ..." name="message">
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    @foreach ($messages as $message)
                        <div>{{ $message }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>