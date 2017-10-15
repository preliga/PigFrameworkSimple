<?php
/* Smarty version 3.1.31, created on 2017-10-15 16:07:20
  from "F:\OneDrive\Programy\Projekty\PHP\PigFramework\public\content\index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_59e36b983469b6_58216199',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b31b9222a6970df8d7b5b28fb76715bb89b7ad44' => 
    array (
      0 => 'F:\\OneDrive\\Programy\\Projekty\\PHP\\PigFramework\\public\\content\\index.tpl',
      1 => 1506529342,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59e36b983469b6_58216199 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '2703759e36b98330ce5_78456643';
?>
<div class="container">

    <div class="bg-faded p-4 my-4">
        <!-- Welcome Message -->
        <div class="text-center mt-4">
            <div class="text-heading text-muted text-lg">Welcome To Cinema Center</div>
            <h1 class="my-2">Choose movie</h1>
        </div>

        <!-- Image Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['movies']->value, 'movie');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['movie']->value) {
?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['i']->value == 1) {?>active<?php }?>></li>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </ol>
            <div class="carousel-inner" role="listbox">
                <?php $_smarty_tpl->_assignInScope('i', 0);
?>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['movies']->value, 'movie');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['movie']->value) {
?>
                    <div class="carousel-item <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>active<?php }?>">
                        <img class="d-block img-fluid w-100" src="data:image/png;base64,<?php if (!empty($_smarty_tpl->tpl_vars['movie']->value['poster'])) {?> <?php echo $_smarty_tpl->tpl_vars['movie']->value['poster'];?>
 <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['emptyPoster']->value;?>
 <?php }?>" style="width: 600px; height: 400px;" alt="">
                        <div class="carousel-caption d-none d-md-block">
                            <h1 class="text-shadow" style="cursor: pointer;" onclick="window.location = '/movie/movie?movieId=<?php echo $_smarty_tpl->tpl_vars['movie']->value['id'];?>
'">
                                <strong>
                                    <?php echo $_smarty_tpl->tpl_vars['movie']->value['title'];?>

                                </strong>
                            </h1>
                        </div>
                    </div>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

            </div>

            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </div>

</div>
<?php }
}
