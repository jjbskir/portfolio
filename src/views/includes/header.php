<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	
	  ga('create', 'UA-25564736-3', 'historyoftoysgallery.com');
	  ga('send', 'pageview');
	
	</script>

    <!-- Le styles -->
    <link href= "{{ app.request.basepath }}/css/bootstrap.css" rel="stylesheet">
    
    <style type="text/css">
        
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
      
        hr {
            height: .08em;
            background-color: grey;
        }
        
        h1, h2, h3 {
            color: #333;
            text-align: center;
        }
        
        button {
            margin-top: 20px;
            margin-bottom: 40px;
        }

        .container {
            text-align: center;
        }
      
    </style>
    
    
    <link href="{{ app.request.basepath }}/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="{{ app.request.basepath }}/css/{{ assets }}.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <!-- script placed here for gallery.php view. -->
    <script src="{{ app.request.basepath }}/js/jquery.js"></script>

  </head>

  <body>

      
    <!-- nav bar -->  
    <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="brand" href="{{ path('home') }}">
                    {{ name }}
                </a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active"><a href="{{ path('home') }}">Home</a></li>
                        <li><a href="{{ path('portfolio') }}">Portfolio</a></li>
                        <li><a href="{{ path('about') }}">About</a></li>
                        <li><a href="{{ path('contact') }}">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>