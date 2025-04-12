<?php

/** @var yii\web\View $this */

$this->title = 'SMK MUHAMMADIYAH 2 AJIBARANG';
?>
<div class="site-index">

    <!-- <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Jurnal Guru</h1>
        <p class="lead">SD NEGERI 1 PEKUNCEN.</p>
    </div> -->

    <!-- Carousel Bootstrap dengan ukuran sedang -->
    <div class="container d-flex justify-content-center">
        <div id="carouselExampleIndicators" class="carousel slide mb-5" data-ride="carousel" style="width: 50%;">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?= Yii::getAlias('@web/img/smk 1.jpg') ?>" class="d-block w-100" alt="Slide 1" style="height: 300px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="<?= Yii::getAlias('@web/img/smk2.jpg') ?>" class="d-block w-100" alt="Slide 2" style="height: 300px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="<?= Yii::getAlias('@web/img/smk3.jpg') ?>" class="d-block w-100" alt="Slide 3" style="height: 300px; object-fit: cover;">
                </div>
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

    <!-- Content Below Carousel -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2> SMK MUHAMMADIYAH 2 AJIBARANG</h2>
                <p class="lead">Selamat datang di sistem Jurnal Guru kami.</p>
            </div>
        </div>
    </div>

</div>
