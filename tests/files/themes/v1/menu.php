<nav class="navbar navbar-expand-md fixed-top navbar-light bg-light">
    <a class="navbar-brand" href="/">
        <img src="https://maxcdn.icons8.com/Share/icon/Music//metal_music1600.png" width="30" height="30" alt="">
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav ml-auto">
    <?php foreach ($items as $key => $item) : ?>
        <a class="nav-item nav-link" href="<?= $item->getLink() ?>"><?= $item->getName() ?></a>
    <?php endforeach; ?>
    </div>
  </div>
</nav>