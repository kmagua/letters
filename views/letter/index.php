<?php

use app\models\Letter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\LetterSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Letters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="letter-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('New Letter', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'organization_id',
            'date',
            'reference_number',
            'title',
            'date_received',
            //'letter',
            //'response_required',
            //'response_letter',
            //'status',
            //'date_created',
            //'last_modified',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Letter $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
