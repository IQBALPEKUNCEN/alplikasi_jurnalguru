<header id="header">
    <?php

    use app\modules\UserManagement\components\GhostNav;
    use app\modules\UserManagement\UserManagementModule;
    use yii\bootstrap4\NavBar;
    use yii\bootstrap4\Html;

    $username = '';
    $rolesString = '';

    // Pastikan untuk memeriksa apakah user sudah login (bukan guest)
    if (!Yii::$app->user->isGuest) {
        // Mengambil username dari user yang login
        $username = Yii::$app->user->identity->username;

        if (!Yii::$app->user->isSuperadmin) {
            $roles = Yii::$app->user->identity->roles;

            // Pastikan roles ada
            $roleNames = array_map(function ($role) {
                return strtolower($role->name);
            }, $roles);

            $rolesString = implode(', ', $roleNames);
        } else {
            $rolesString = 'Superadmin';
        }

        // Ubah username menjadi huruf kecil
        $username = strtolower($username);
    }

    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top no-print']
    ]);

    echo GhostNav::widget([
        'options' => ['class' => 'navbar-nav'],
        'encodeLabels' => false,
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index'], 'visible' => true],
<<<<<<< HEAD

            // Opsi Data Sekolah
            [
                'label' => 'Data Sekolah',
                'url' => ['#'],
                'template' => '<a href="{url}">{label}<i class="fa fa-angle-left pull-right"></i></a>',
                'items' => [
                    ['label' => 'Tahun Ajaran', 'url' => ['/tahunajaran/index']],
                    ['label' => 'Jenjang', 'url' => ['/jenjang/index']],
                    ['label' => 'Kelas', 'url' => ['/kelas/index']], 
                    ['label' => 'Siswa', 'url' => ['/siswa/index']],
                    ['label' => 'Guru', 'url' => ['/guru/index']],
                ],
                // 'visible' => $username !== 'iqbal', // Sembunyikan menu untuk user iqbal
            ],

            // Opsi Data Jurnal
            [
                'label' => 'Data Jurnal',
                'url' => '#',
                'template' => '<a href="{url}">{label}<i class="fa fa-angle-left pull-right"></i></a>',
                'items' => [
                    ['label' => 'Mapel', 'url' => ['/mapel/index']],
                    ['label' => 'Jurnal', 'url' => ['/jurnal/index']],
                ],
            ],

            // Opsi Laporan - sembunyikan untuk user iqbal dan saat di halaman index
            [
                'label' => 'Laporan',
                'url' => ['/jurnal/laporan'],
                // 'visible' => $username !== 'iqbal' && Yii::$app->controller->action->id !== 'index',
            ],

            // Opsi User Management
=======
            ['label' => 'Hari', 'url' => ['/hari/index'], 'visible' => true],
            ['label' => 'Guru', 'url' => ['/guru/index'], 'visible' => true],
            ['label' => 'History kelas', 'url' => ['/historykelas/index'], 'visible' => true],
            ['label' => 'Jenjang', 'url' => ['/jenjang/index'], 'visible' => true],
            ['label' => 'Jurnal', 'url' => ['/jurnal/index'], 'visible' => true],
            ['label' => 'Jurnal detil', 'url' => ['/jurnal-detil/index'], 'visible' => true],
            ['label' => 'Jurusan', 'url' => ['/jurusan/index'], 'visible' => true],
            ['label' => 'Kelas', 'url' => ['/kelas/index'], 'visible' => true],
            ['label' => 'Mapel', 'url' => ['/mapel/index'], 'visible' => true],
            ['label' => 'Siswa', 'url' => ['/siswa/index'], 'visible' => true],
            ['label' => 'Tahun ajaran', 'url' => ['/tahunajaran/index'], 'visible' => true],
>>>>>>> a6e311bdffd97bea8565158ca4863bc50d6fc4da
            [
                'label' => 'User Management',
                'url' => '#',
                'template' => '<a href="{url}">{label}<i class="fa fa-angle-left pull-right"></i></a>',
                'items' => UserManagementModule::menuItems(),
            ],

            // Opsi Exit Login
            ['label' => 'Exit Login', 'url' => ['/user-management/auth/exit-login-as'], 'visible' => (bool) Yii::$app->session->get('user.olduser', null)],

            // Opsi Login dan Logout
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/user-management/auth/login'], 'visible' => true]
                :
                [
                    'label' => 'Logout (' . $username . ')',
                    'url' => ['/user-management/auth/logout'],
                    'template' => '<a href="{url}">{label}<i class="fa fa-angle-left pull-right"></i></a>',
                    'visible' => true,
                    'items' => [
                        '<div class="cardx" style="width: 18rem;">
                            <div class="card-body">
                                ' . Html::img('@web/img/user.jpg', ['class' => 'img-circle mb-3', 'style' => 'width: 3rem;', 'alt' => 'User Image']) . '
                                <h5 class="card-title mb-0">' . $username . '</h5>
                                <h7 class="card-subtitle mb-2 text-muted">' . $rolesString . '</h7>
                                <p class="card-text"></p>
                                <div class="d-flex justify-content-aroundx">
                                ' . Html::a("Ubah Password", ["/user-management/auth/change-own-password"], ["class" => "btn btn-primary btn-sm nowrap mr-2"]) . '
                                ' . Html::a("Logout", ["/user-management/auth/logout"], ["data-method" => "post", "class" => "btn btn-warning btn-sm nowrap"]) . '
                                </div>
                            </div>
                        </div>',
                    ]
                ],
        ]
    ]);
    NavBar::end();
    ?>
</header>
