<?php
/* Smarty version 3.1.31, created on 2017-10-15 16:07:09
  from "F:\OneDrive\Programy\Projekty\PHP\PigFramework\public\layout\templates\admin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59e36b8dbec948_54228962',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '75a6ca07986d92895be04a6597148ea0d23bb97b' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\layout\\templates\\admin.tpl',
      1 => 1508075409,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/components/admin/menu.tpl' => 1,
  ),
),false)) {
function content_59e36b8dbec948_54228962 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1486659e36b8dbbd729_21329123';
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
    <?php $_smarty_tpl->_subTemplateRender("file:layout/components/admin/menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <?php if (file_exists(((string)$_smarty_tpl->tpl_vars['file']->value).".tpl")) {?>
        <?php $_smarty_tpl->_subTemplateRender(((string)$_smarty_tpl->tpl_vars['file']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

    <?php }?>
</div>

<footer class="bg-faded text-center py-1" style="position:fixed; bottom:0; width: 100%;">
    <div class="container">
        <a href="/admin/login"> Admin panel</a>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<?php echo '<script'; ?>
 src="/scripts/lib/jquery/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/scripts/lib/datetimepicker/jquery.datetimepicker.full.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/scripts/lib/popper/popper.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/scripts/lib/bootstrap/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/scripts/app/common.js"><?php echo '</script'; ?>
>

</body>

</html><?php }
}
