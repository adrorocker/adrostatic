<?php foreach ($categories as $category) : ?>
    <a href="/blog/<?= $category ?>/" class="list-group-item"><?= \Illuminate\Support\Str::title($category) ?></a>
<?php endforeach;
