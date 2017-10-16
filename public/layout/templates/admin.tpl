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
    {include file="layout/components/admin/menu.tpl"}
    {if file_exists("$file.tpl")}
        {include file="{$file}.tpl"}
    {/if}
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

<script data-main="/scripts/app/app" src="/scripts/lib/require.js"></script>
{*<script src="/scripts/app/common.js"></script>*}

</body>

</html>