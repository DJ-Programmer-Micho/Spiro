<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  <div class="sub-customerinfo"><b>{{$client ?? 'UnKnown'}}</b></div>
<div class="customername">{{$country ?? 'Country'}} / {{$city ?? 'City'}}</div>
<div class="sub-customerinfo">{{$email ?? 'Email'}}</div>
<div class="sub-customerinfo">{{$phoneOne ?? '+964'}}</div>
<div class="sub-customerinfo">{{$phoneTwo ?? '+964'}}</div>
</body>
</html>