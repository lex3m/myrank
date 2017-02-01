<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use frontend\models\Marks;

$this->title = Yii::t('app', 'Marks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Marks'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
	    
            'name',
	    [
		'attribute' => 'parent_id',
		//'label' => "Родитель",
		'format' => 'text',
		'content' => function ($data) {
		    $list = Marks::getList();
		    return $list[$data->parent_id];
		},
		'filter' => Marks::getList()
	    ],
		    
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>