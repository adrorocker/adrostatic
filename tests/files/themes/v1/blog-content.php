<div class="row row-offcanvas row-offcanvas-right">
    <div class="col-xs-12 col-sm-9">
        <h2>Blog</h2>
        <hr>
        <?php foreach ($posts as $post) : ?>
        <a href="<?= $post->getLink() ?>"><?= $post->getTitle() ?></a><br>
        <?php endforeach;?>
    </div><!--/.col-xs-12.col-sm-9-->
    <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
        <div class="list-group">
            <h3>Categories</h3>
            <?= $categories ?>
        </div>
    </div><!--/.sidebar-offcanvas-->
</div><!--/row-->
