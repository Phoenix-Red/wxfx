<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>支付</title>
</head>
<body>
	<form action="/pay" method="post">
		{!!csrf_field()!!}
		<input type="hidden" name="oid" value="{{$oid}}">
		<input class="btn btn-primary" type="submit" value="立即支付" >
	</form>
</body>
</html>