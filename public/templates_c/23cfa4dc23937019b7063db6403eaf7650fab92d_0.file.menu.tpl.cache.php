<?php
/* Smarty version 3.1.31, created on 2017-10-15 16:07:09
  from "F:\OneDrive\Programy\Projekty\PHP\PigFramework\public\layout\components\admin\menu.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59e36b8dc03061_50100206',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23cfa4dc23937019b7063db6403eaf7650fab92d' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\layout\\components\\admin\\menu.tpl',
      1 => 1508073311,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59e36b8dc03061_50100206 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '2608359e36b8dbfdeb5_74128746';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-4">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['path']->value[2] == 'movies') {?> active <?php }?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['path']->value[2] == 'repertoire') {?> active <?php }?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/repertoire/repertoire">Repertoire</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav><?php }
}
