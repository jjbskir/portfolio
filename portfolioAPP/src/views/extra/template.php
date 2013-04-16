<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Portfolio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    
    <link href= "{{ app.request.basepath }}/css/bootstrap.css" rel="stylesheet">
    
    <!-- graph javascript-->
    <script src="{{ app.request.basepath }}/js/jsgraphics.js"></script>
    <script src="{{ app.request.basepath }}/js/line.js"></script>

    
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="{{ app.request.basepath }}/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

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
                <a class="brand" href=""{{ path('home') }}">
                    {{ adminFirstName }} {{ adminLastName }}
                </a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active"><a href="{{ path('home') }}">Home</a></li>
                        <li><a href="{{ path('portfolio') }}">Portfolio</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>

    
    <!-- Main content -->  
        

        
         <!-- footer -->  
        <hr>
        <footer>
            <p>&copy; Company 2012</p>
        </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster-->
    <script src="{{ app.request.basepath }}/js/jquery.js"></script> 
    <script src="{{ app.request.basepath }}/js/bootstrap-collapse.js"></script>

    

    </body>
</html>
