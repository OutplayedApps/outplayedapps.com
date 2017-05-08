<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-type" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, width=device-width">
    <meta name="description" content="">
    <meta name="author" content="">

    <meta property="og:url" content="<?php echo get_permalink(); ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo has_post_thumbnail() ? the_post_thumbnail_url(): "http://outplayedapps.com/wp-content/uploads/2017/04/logo.png"; ?>" />
    <meta property="og:title" content="<?php echo 'Outplayed - '; echo the_title(); ?>" />
    <meta property="og:description" content="<?php echo the_excerpt(); ?>" />
    <meta property="og:image:width" content="1461" />
    <meta property="og:image:height" content="831" />

    <title>Outplayed Apps</title>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-28518772-5', 'auto');
  ga('send', 'pageview');

</script>
    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-creative/3.3.7/css/creative.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <?php wp_head() ?>
    
<?php $slug = slug(); ?>
</head>

<body id="page-top">

    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="/">Outplayed</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="">
                        <a class="page-scroll" href="<?php echo slug() != "" ? "/":""; ?>#services">Our services</a>
                    </li>
                    <li class=" <?php echo $slug=="new-website-launch"?"active":"" ?>">
                        <a class="page-scroll" href="/blog">Blog</a>
                    </li>
                    <li class=" <?php echo slug()=="science-bowl"?"active":"" ?>">
                        <a class="page-scroll" href="/science-bowl">Science Bowl</a>
                    </li>
                    <li class=" <?php echo slug()=="courses"?"active":"" ?>">
                        <a class="page-scroll" href="/courses">Summer Courses</a>
                    </li>
                    <li class=" <?php echo slug()=="about"?"active":"" ?>">
                        <a class="page-scroll" href="/about">About us</a>
                    </li>
                    <li class=" <?php echo slug()=="contact"?"active":"" ?>">
                        <a class="page-scroll" href="/contact">Contact us</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>