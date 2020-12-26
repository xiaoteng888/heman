<!DOCTYPE html>
<html>
<head>
	<title>@yield('title','微博APP')-练习项目</title>
	<link rel="stylesheet" type="text/css" href="{{mix('css/app.css')}}">
</head>
<body>
      @include('layouts._header')
    <div class="container">
    	<div class="offset-md-1 col-md-10">
    	  @include('shared._messages')
	      @yield('content')
	      @include('layouts._footer')
        </div>
    </div>
  <script type="text/javascript" src="{{mix('js/app.js')}}"></script>
</body>
</html>