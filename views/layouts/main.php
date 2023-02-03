<?php
use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
$web = Yii::getAlias('@web');
?>
<?php $this->beginPage() ?>
<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?= $web?>/favicon.ico" type="image/ico" />
	<!--plugins-->
	<link href="<?= $web?>/themeassets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="<?= $web?>/themeassets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?= $web?>/themeassets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="<?= $web?>/themeassets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="<?= $web?>/themeassets/css/pace.min.css" rel="stylesheet" />
	<script src="<?= $web?>/themeassets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<!--<link href="<?= $web?>/themeassets/css/bootstrap.min.css" rel="stylesheet">-->
	<link href="<?= $web?>/themeassets/css/app.css" rel="stylesheet">
	<link href="<?= $web?>/themeassets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?= $web?>/themeassets/css/dark-theme.css" />
	<link rel="stylesheet" href="<?= $web?>/themeassets/css/semi-dark.css" />
	<link rel="stylesheet" href="<?= $web?>/themeassets/css/header-colors.css" />
	<title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<?php $this->beginBody() ?>
<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true" style="background-color: #E7E7E7 !important;">
			<div class="sidebar-header">
				<div>
					<img src="<?= $web?>/logo.png" style="width:100%!important; height:auto" alt="logo icon">
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
            
			<!--navigation-->
			<ul class="metismenu" id="menu">				
				<li>
					<a href="<?= $web;?>">
						<div class="parent-icon">
                            <i class="bx bx-home"></i>
						</div>
						<div class="menu-title">Home</div>
					</a>
                    <?php if(Yii::$app->user->isGuest){ ?>
                    <a href="<?= $web;?>/site/login">
						<div class="parent-icon">
                            <i class="bx bx-lock-open"></i>
						</div>
						<div class="menu-title">Login</div>
					</a>
                    <?php }else{ ?>
                    <a href="<?= $web;?>/user/view?id=<?= Yii::$app->user->identity->id ?>">
						<div class="parent-icon">
                            <i class="bx bx-user"></i>
						</div>
						<div class="menu-title">My Profile</div>
					</a>
                    <?php } ?>
                    <?php if((!Yii::$app->user->isGuest && Yii::$app->user->identity->isInternal())){ ?>
                    <a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-user-pin"></i>
						</div>
						<div class="menu-title">Admin Links</div>
					</a>
					<ul>
						<li>
                            <a href="<?= $web?>/organization/index"><i class="bx bx-right-arrow-alt"></i>Organizations</a>
						</li>
						<li>
                            <a href="<?= $web?>/user/index"><i class="bx bx-right-arrow-alt"></i>User Management</a>
						</li>                        
					</ul>
                    <?php } ?>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand" style="background-color: #EC232A !important">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						
					</div>
					<div class="top-menu ms-auto" style="display: none">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
							
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count"></span>
									<i class='bx bx-bell'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									
									<div class="header-notifications-list">									
										
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Notifications</div>
									</a>
								</div>
                                </div>
							</li>
							<li class="nav-item dropdown dropdown-large">
								<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count"></span>
									<i class='bx bx-comment'></i>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="javascript:;">
										<div class="msg-header">
											<p class="msg-header-title">Messages</p>
											<p class="msg-header-clear ms-auto">Marks all as read</p>
										</div>
									</a>
									<div class="header-message-list">
										<a class="dropdown-item" href="javascript:;">
											<div class="d-flex align-items-center">
											</div>
										</a>
										
									</div>
									<a href="javascript:;">
										<div class="text-center msg-footer">View All Messages</div>
									</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?= $web?>/images/usr-avatar.jpg" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
                                <p class="user-name mb-0" style="color:#fff; font-weight: bold"><?= (Yii::$app->user->isGuest)?
                                    "Guest":Yii::$app->user->identity->getName() ?></p>
								<p class="designattion mb-0" style="color:#fff"><?= (Yii::$app->user->isGuest)?
                                    "": Yii::$app->user->identity->getOrgOr() ?></p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
                            <?php if(!Yii::$app->user->isGuest) { ?>
							<li>
                                <a class="dropdown-item" href="<?= $web ?>/user/view?id=<?= Yii::$app->user->identity->id ?>"><i class="bx bx-user"></i><span>Profile</span></a>
							</li>
							
                            <li class="dropdown-item" ><?= Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout',
                        ['class' => 'bx bx-log-out-circle nav-link btn btn-link logout', 'style'=>'width:100%; text-align:left']
                    )
                    . Html::endForm(); ?>
							</li>
                            <?php }else{ ?>
                                <li>
                                    <a class="dropdown-item" href="<?= $web ?>/site/login"><i class="bx bx-user"></i><span>Login</span></a>
                                </li>
                            <?php } ?>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<main id="main" class="flex-shrink-0" role="main">
                <div class="container" style="margin-top: 0px!important;  padding-top:0px !important;">
                    <?php if (!empty($this->params['breadcrumbs'])): ?>
                        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
                    <?php endif ?>
                    <?= Alert::widget() ?>
                    <?= app\models\User::getUserNotification(); ?>
                    <?= $content ?>
                </div>
                <div class="chart-container-1" style="display:none">
                    <canvas id="chart1"></canvas><canvas id="chart2"></canvas>
                </div>
            </main>
            <footer id="footer" class="mt-auto py-3 bg-light">
                <div class="container">
                    <div class="row text-muted">
                        <div class="col-md-6 text-center text-md-start">&copy; ICT Authority <?= date('Y') ?></div>
                        <div class="col-md-6 text-center text-md-end"></div>
                    </div>
                </div>
            </footer>
        </div>
	</div>
	
<?php
yii\bootstrap5\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'letters-sys-modal',
    'size' => 'modal-lg',
    //'class' => 'modal',
    'closeButton' => [
        'id' => 'close-button',
        'class' => 'close',
        'data-dismiss' => 'modal',
    ],
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'options' => [
        'data-backdrop' => 'static', 'keyboard' => true,
        'tabindex' => -1,
        //'class' => 'modal'
    ]
]);
echo "<div id='modalContent'><div style='text-align:center'></div></div>";
echo '<div class="modal-footer">
        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close Dialog</button>
      </div>';
yii\bootstrap5\Modal::end();
?>
<?php
//$path = Yii::getAlias('@web');
$js = <<<JS
var basePathWeb = '$web'
$('#letters-sys-modal').on('hidden.bs.modal', function () {
    if (typeof refresh_on_close === 'undefined') {
        location.reload();
    }
})

JS;

$this->registerJs($js, yii\web\View::POS_END, 'refresh_on_close_modal');
?>
<?php
$this->registerJsFile($web . '/js/general_js.js', ['position' => yii\web\View::POS_END]);
?>
<?php $this->endBody() ?>
    <!--end switcher-->
	<!-- Bootstrap JS -->
	<!--<script src="<?= $web?>/themeassets/js/bootstrap.bundle.min.js"></script>-->
	<!--plugins-->
	<!-- <script src="<?=''// $web?>/themeassets/js/jquery.min.js"></script>-->
    <script src="<?= $web?>/themeassets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="<?= $web?>/themeassets/plugins/simplebar/js/simplebar.min.js"></script>
	
	<script src="<?= $web?>/themeassets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--<<script src="<?= $web?>/themeassets/plugins/chartjs/js/Chart.min.js"></script>
	script src="<?= $web?>/themeassets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?= $web?>/themeassets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?= $web?>/themeassets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="<?= $web?>/themeassets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
	<script src="<?= $web?>/themeassets/plugins/jquery-knob/excanvas.js"></script>
	<script src="<?= $web?>/themeassets/plugins/jquery-knob/jquery.knob.js"></script>-->
	  
	<!--  <script src="<?= $web?>/themeassets/js/index.js"></script>
	app JS-->
	<script src="<?= $web?>/themeassets/js/app.js"></script>
</body>
</html>
<?php $this->endPage() ?>
	
