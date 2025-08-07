<header id="header">
    <?php

    use app\modules\UserManagement\components\GhostNav;
    use app\modules\UserManagement\UserManagementModule;
    use yii\bootstrap4\NavBar;
    use yii\bootstrap4\Html;

    $username = '';
    $rolesString = '';

    if (!Yii::$app->user->isGuest) {
        $username = Yii::$app->user->identity->username;

        if (!Yii::$app->user->isSuperadmin) {
            $roles = Yii::$app->user->identity->roles;
            $roleNames = array_map(function ($role) {
                return strtolower($role->name);
            }, $roles);
            $rolesString = implode(', ', $roleNames);
        } else {
            $rolesString = 'Superadmin';
        }

        $username = strtolower($username);
    }

    // Custom CSS for enhanced navbar
    $this->registerCss("
        .navbar-enhanced {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .navbar-enhanced:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: #fff !important;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .navbar-brand:hover {
            color: #f8f9fa !important;
            transform: translateY(-2px);
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }
        
        .navbar-brand i {
            margin-right: 8px;
            font-size: 1.2em;
            color: #ffd700;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0 4px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .navbar-nav .nav-link:hover::before {
            left: 100%;
        }
        
        .navbar-nav .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-nav .nav-link i {
            margin-right: 6px;
            font-size: 0.9em;
            transition: transform 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover i {
            transform: scale(1.2);
        }
        
        .dropdown-menu {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            padding: 0.5rem 0;
            margin-top: 8px;
        }
        
        .dropdown-item {
            color: #fff !important;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 8px;
            font-weight: 500;
        }
        
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item i {
            margin-right: 8px;
            width: 18px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .dropdown-item:hover i {
            transform: scale(1.2);
        }
        
        .user-dropdown-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            color: #fff;
            padding: 1.5rem;
            margin: 0.5rem;
            backdrop-filter: blur(10px);
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .user-dropdown-card .card-title {
            font-weight: 600;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        
        .user-dropdown-card .card-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        
        .user-dropdown-card .img-circle {
            border: 3px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }
        
        .user-dropdown-card .img-circle:hover {
            border-color: #ffd700;
            transform: scale(1.1);
        }
        
        .user-dropdown-card .btn {
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            padding: 0.5rem 1rem;
        }
        
        .user-dropdown-card .btn-primary {
            background: linear-gradient(45deg, #28a745, #20c997);
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        
        .user-dropdown-card .btn-primary:hover {
            background: linear-gradient(45deg, #218838, #1ea87a);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        
        .user-dropdown-card .btn-warning {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }
        
        .user-dropdown-card .btn-warning:hover {
            background: linear-gradient(45deg, #e0a800, #e8590c);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .navbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        .navbar-toggler-icon {
            background-image: url('data:image/svg+xml;charset=utf8,<svg viewBox=\"0 0 30 30\" xmlns=\"http://www.w3.org/2000/svg\"><path stroke=\"rgba(255, 255, 255, 0.9)\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-miterlimit=\"10\" d=\"M4 7h22M4 15h22M4 23h22\"/></svg>');
        }
        
        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .navbar-nav {
                padding: 1rem 0;
            }
            
            .navbar-nav .nav-link {
                margin: 2px 0;
            }
            
            .user-dropdown-card {
                margin: 0.5rem 0;
            }
        }
        
        /* Smooth scrolling effect */
        html {
            scroll-behavior: smooth;
        }
        
        /* Loading animation for navbar */
        .navbar-enhanced {
            animation: fadeInDown 0.5s ease;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    ");

    NavBar::begin([
        'brandLabel' => '<i class="fas fa-graduation-cap"></i> ' . Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark navbar-enhanced fixed-top no-print']
    ]);

    echo GhostNav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<i class="fas fa-home"></i> Home', 'url' => ['/site/index']],

            [
                'label' => '<i class="fas fa-building"></i> Data Sekolah',
                'url' => '#',
                'items' => [
                    ['label' => '<i class="fas fa-calendar-alt"></i> Tahun Ajaran', 'url' => ['/tahunajaran/index']],
                    ['label' => '<i class="fas fa-layer-group"></i> Jenjang', 'url' => ['/jenjang/index']],
                    ['label' => '<i class="fas fa-stream"></i> Jurusan', 'url' => ['/jurusan/index']],
                    ['label' => '<i class="fas fa-door-open"></i> Kelas', 'url' => ['/kelas/index']],
                    ['label' => '<i class="fas fa-user-graduate"></i> Siswa', 'url' => ['/siswa/index']],
                    ['label' => '<i class="fas fa-chalkboard-teacher"></i> Guru', 'url' => ['/guru/index']],
                    ['label' => '<i class="fas fa-door-closed"></i> Ruangan', 'url' => ['/ruangan/index']],
                    //['label' => '<i class="fas fa-history"></i> History Kelas', 'url' => ['/historykelas/index']],
                ],
            ],

            [
                'label' => '<i class="fas fa-book-open"></i> Data Jurnal',
                'url' => '#',
                'items' => [
                    ['label' => '<i class="fas fa-book"></i> Mapel', 'url' => ['/mapel/index']],
                    ['label' => '<i class="fas fa-calendar-alt"></i> Jadwal', 'url' => ['/jadwal/index'],],
                    ['label' => '<i class="fas fa-pen-square"></i> Jurnal', 'url' => ['/jurnal/index']],
                    ['label' => '<i class="fas fa-tasks"></i> Tugas', 'url' => ['/tugas/index']],
                    ['label' => '<i class="fas fa-history"></i> Nilai', 'url' => ['/nilai/index']],
                    ['label' => '<i class="fas fa-upload"></i> Pengumpulan Tugas', 'url' => ['/pengumpulan-tugas/index']],



                ],
            ],

            [
                'label' => '<i class="fas fa-file-alt"></i> Laporan',
                'url' => '#',
                'items' => [
                    [
                        'label' => '<i class="fas fa-user-check"></i> Laporan Siswa',
                        'url' => ['/jurnal/laporan-siswa'],
                    ],
                    [
                        'label' => '<i class="fas fa-chalkboard-teacher"></i> Laporan Guru',
                        'url' => ['/jurnal/laporan-guru'],
                    ],
                    [
                        'label' => '<i class="fas fa-clock"></i> Jadwal Siswa',
                        'url' => ['/jadwal/jadwal-siswa'],
                    ],
                    [
                        'label' => '<i class="fas fa-file-alt"></i> Nilai Siswa',
                        'url' => ['/nilai/nilai-siswa'],
                    ],
                    ['label' => '<i class="fas fa-file-alt"></i> Tugas Siswa', 'url' => ['/tugas/tugas-siswa']],
                    ['label' => '<i class="fas fa-history"></i> Pengumpulan tugas siswa', 'url' => ['/pengumpulan-tugas/history']],


                ]
            ],

            [
                'label' => '<i class="fas fa-users-cog"></i> User Management',
                'url' => '#',
                'items' => UserManagementModule::menuItems(),
            ],

            ['label' => '<i class="fas fa-sign-out-alt"></i> Exit Login', 'url' => ['/user-management/auth/exit-login-as'], 'visible' => (bool) Yii::$app->session->get('user.olduser', null)],

            Yii::$app->user->isGuest
                ? ['label' => '<i class="fas fa-sign-in-alt"></i> Login', 'url' => ['/user-management/auth/login']]
                : [
                    'label' => '<i class="fas fa-user-circle"></i> ' . $username,
                    'url' => ['/user-management/auth/logout'],
                    'items' => [
                        '<div class="user-dropdown-card" style="width: 20rem;">
                            <div class="card-body text-center">
                                ' . Html::img('@web/img/user.jpg', [
                            'class' => 'img-circle mb-3',
                            'style' => 'width: 4rem; height: 4rem; object-fit: cover;',
                            'alt' => 'User Image'
                        ]) . '
                                <h5 class="card-title mb-1">' . ucfirst($username) . '</h5>
                                <p class="card-subtitle mb-3">' . ucfirst($rolesString) . '</p>
                                <div class="d-flex justify-content-center gap-2">
                                    ' . Html::a('<i class="fas fa-key"></i> Ubah Password', ["/user-management/auth/change-own-password"], [
                            "class" => "btn btn-primary btn-sm"
                        ]) . '
                                    ' . Html::a('<i class="fas fa-sign-out-alt"></i> Logout', ["/user-management/auth/logout"], [
                            "data-method" => "post",
                            "class" => "btn btn-warning btn-sm"
                        ]) . '
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