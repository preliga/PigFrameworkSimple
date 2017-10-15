<?php
/* Smarty version 3.1.31, created on 2017-10-15 18:07:58
  from "F:\OneDrive\Programy\Projekty\PHP\PigFramework\public\layout\templates\admin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59e387debdcc58_85328417',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75a6ca07986d92895be04a6597148ea0d23bb97b' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\layout\\templates\\admin.tpl',
      1 => 1508075409,
      2 => 'file',
    ),
    '23cfa4dc23937019b7063db6403eaf7650fab92d' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\layout\\components\\admin\\menu.tpl',
      1 => 1508073311,
      2 => 'file',
    ),
    '7251956104884dc7789d1de9897e648e75886349' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\content\\admin\\movies\\addmovie.tpl',
      1 => 1508073217,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 0,
),true)) {
function content_59e387debdcc58_85328417 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cinema</title>

    <!-- Bootstrap core CSS -->
    <link href="/scripts/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800"
          rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:100,300,400,600,700,100italic,300italic,400italic,600italic,700italic"
          rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="/scripts/lib/css/business-casual.css">
    <link rel="stylesheet" href="/scripts/lib/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/scripts/lib/datetimepicker/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="/scripts/app/style.css">



</head>

<body>
<div class="tagline-upper text-center text-heading text-shadow text-white mt-5 d-none d-lg-block"
     onclick="window.location = '/'" style="cursor: pointer;">
    Cinema Center
</div>

<div class="page">
    <nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-4">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item  active  px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item  px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/repertoire/repertoire">Repertoire</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
            <br>
<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-2">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item  px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link  text-uppercase text-expanded" href="/admin/movies/addmovie">Add Movies</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="bg-faded" style="padding: 10px; text-align: center;">
    <h1 class="page-header">Add movies</h1>


    <div>
        <div class="container">
            <div class="well well-sm">
                <form action="/admin/movies/addmovie" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Title
                                </label>
                                <input type="text" class="form-control" name="title" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Trailer link
                                </label>
                                <input type="text" class="form-control" name="trailer" />
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Duration
                                </label>
                                <input type="time" class="form-control" name="duration" required="required" />
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Category
                                </label>
                                <select name="category" class="form-control" required="required">
                                    
                                        <option value="">-- Choose category --</option>
                                                                                    <option value="1">action adventure film</option>
                                                                                    <option value="2">action movie </option>
                                                                                    <option value="3">animated movie</option>
                                                                                    <option value="4">biograghical film</option>
                                                                                    <option value="5">cartoon</option>
                                                                                    <option value="8">comedy</option>
                                                                                    <option value="7">comedy-drama</option>
                                                                                    <option value="6">crime film</option>
                                                                                    <option value="9">documentary film</option>
                                                                                    <option value="10">horror</option>
                                                                                    <option value="11">science fiction film</option>
                                                                                    <option value="12">sport film</option>
                                                                                    <option value="13">thriller </option>
                                                                                    <option value="14">western </option>
                                        
                                    
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">
                                    Description
                                </label>
                                <textarea name="description" class="form-control" rows="9" cols="25"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="name">
                                    Poster
                                </label>
                                <input type="file" class="form-control" name="poster" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
                            </div>
        </div>
    </div>

</div>
    </div>

<footer class="bg-faded text-center py-1" style="position:fixed; bottom:0; width: 100%;">
    <div class="container">
        <a href="/admin/login"> Admin panel</a>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="/scripts/lib/jquery/jquery.min.js"></script>
<script src="/scripts/lib/datetimepicker/jquery.datetimepicker.full.min.js"></script>
<script src="/scripts/lib/popper/popper.min.js"></script>
<script src="/scripts/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/scripts/app/common.js"></script>

</body>

</html><?php }
}
