<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Country */

$this->title = 'Добавить страну';
$this->params['breadcrumbs'][] = ['label' => 'Страны', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
