<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            {{session('success')}}
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <label>Tên Quận:</label>
        <input type="text" name="name"/>
        <label>Thuộc thành phố</label>
        <select name="id_country">
            @foreach($countries as $country)
            <option value="{{$country->id}}">{{$country->name}}</option>
            @endforeach
        </select>
        <br>
        <button type="submit">Nhập</button>
        @csrf
    </form>
</body>
</html>