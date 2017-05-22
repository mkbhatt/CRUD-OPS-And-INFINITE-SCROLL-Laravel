<!DOCTYPE html>
<head>

	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href='http://fonts.googleapis.com/css?family=Droid+Serif|Open+Sans:400,700' rel='stylesheet' type='text/css'>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	
	@yield('insert_head')
	@yield('index_head')
	@yield('modify_head')

    <title>{{$crud_title}}</title>

    
</head>
<body>

@yield('menu')

@yield('content')

<script src="{{ URL::to('static/js/moment.js')}}"></script>

</body>
</html>

