<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Marks1 */

$this->title = 'Обновить оценку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Наименования оценок', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="marks1-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>