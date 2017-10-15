<?php
/* Smarty version 3.1.31, created on 2017-10-15 16:07:09
  from "F:\OneDrive\Programy\Projekty\PHP\PigFramework\public\content\admin\movies\addmovie.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59e36b8dc2e5c6_37662742',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7251956104884dc7789d1de9897e648e75886349' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\content\\admin\\movies\\addmovie.tpl',
      1 => 1508073217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59e36b8dc2e5c6_37662742 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '1532859e36b8dc17298_49076717';
?>
<br>
<nav class="navbar navbar-expand-lg navbar-light bg-faded py-lg-2">
    <div class="container">
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item <?php if ($_smarty_tpl->tpl_vars['path']->value[3] == 'movies') {?> active <?php }?> px-lg-4">
                    <a class="nav-link text-uppercase text-expanded" href="/admin/movies/movies">Movies</a>
                </li>
                <li class="nav-item px-lg-4">
                    <a class="nav-link <?php if ($_smarty_tpl->tpl_vars['path']->value[3] == 'addmovies') {?> active <?php }?> text-uppercase text-expanded" href="/admin/movies/addmovie">Add Movies</a>
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
                                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category']->value, 'cat');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->value) {
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['cat']->value['name'];?>
</option>
                                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

                                    
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
                <?php if (!empty($_smarty_tpl->tpl_vars['saveCorrect']->value)) {?>
                    <br>
                    <strong><span style="color: #00dd1c">Save correct</span></strong>
                <?php }?>
            </div>
        </div>
    </div>

</div><?php }
}
