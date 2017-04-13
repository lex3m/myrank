<?php

use yii\widgets\ListView;
use frontend\widgets\user\LatestUsersAddWidget;
use frontend\widgets\user\BestRatingWidget;
use frontend\models\Profession;
use yii\helpers\Url;
use frontend\models\User;

$this->title = 'MyRank.com';
$mProf = Profession::find()->asArray()->all();
?>

<!-- begin b-category -->
<div class="b-category">
    <div class="container">
	<h2>
        <?= \Yii::t('app','TOP_CATEGORIES'); ?>
	</h2>
	<div class="b-category__content">
	    <div class="row">
		<?php foreach ($mProf as $key => $item) { ?>
		    <?php if (($key == 0) || ($key % 5) == 0) { ?>
			<div class="col-xs-12 col-sm-6 col-md-3">
			    <ul>
			    <?php } ?>
				<li>
				    <a href="<?= Url::toRoute(['users/search', 'professionField' => $item['id']]) ?>">
					<?= $item['title'] ?>
				    </a>
				</li>
			    <?php if ((($key + 1) % 5 == 0) || (count($mProf) == $key+1)) { ?>
			    </ul>
			</div>
		    <?php } ?>
		<?php } ?>
	    </div>
	</div>
    </div>
</div>
<!-- end b-category -->

<!-- begin b-rating -->
<?= BestRatingWidget::widget(); ?>
<!-- end b-rating -->


<!-- begin b-info -->
<div class="b-info">
    <div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-6">
		<div class="b-info__about">
		    <h2><?= \Yii::t('app','LITTLE_ABOUT_THE_PROJECT'); ?></h2>
		    <div class="b-info__about__content"><?= \Yii::t('app','LITTLE_ABOUT_THE_PROJECT_TEXT'); ?></div>
		</div>
	    </div>
	    <div class="col-xs-12 col-sm-6">
		<div class="b-info__how-work">
		    <h2>Как работает сервис</h2>
		    <div class="b-info__how-work__content">
			<ul>
			    <li><span class="b-info__how-work__icon b-info__how-work__icon_1"></span>
				<span class="b-info__how-work__text">Регистрация Пользователя/Компании</span>
			    </li>
			    <li>
				<span class="b-info__how-work__icon b-info__how-work__icon_2"></span>
				<span class="b-info__how-work__text">Заполните информацию о профиле, чтобы получить максимально высокий бал.</span>
			    </li>
			    <li>
				<span class="b-info__how-work__icon b-info__how-work__icon_3"></span>
				<span class="b-info__how-work__text">Оценивайте партнеров, коллег и знакомых, оставляйте о них отзывы.</span>
			    </li>
			    <li>
				<span class="b-info__how-work__icon b-info__how-work__icon_4"></span>
				<span class="b-info__how-work__text">Повышайте рейтинг профиля, получайте отзывы.</span>
			    </li>
			    <li>
				<span class="b-info__how-work__icon b-info__how-work__icon_5"></span>
				<span class="b-info__how-work__text">Высокий рейтинг - карьерный рост.</span>
			    </li>
			    <li>
				<span class="b-info__how-work__icon b-info__how-work__icon_6"></span>
				<span class="b-info__how-work__text">Ищите партнеров для своего бизнеса.</span>
			    </li>
			</ul>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</div>
<!-- end b-info -->


<!-- begin b-articles -->
<?php
echo ListView::widget([
    'dataProvider' => $listDataProvider,
    'itemView' => '_listArticles',
    'layout' => '{items}',
    'emptyText' => 'Нет статей',
    'emptyTextOptions' => [
	'tag' => 'p'
    ],
]);
?>
<!-- end b-articles -->


<!-- begin b-reg-now -->
<div class="b-reg-now">
    <div class="container">
	<div class="b-reg-now__content">
	    <div class="b-reg-now__text">
		Зарегистрируйтесь и получите <span>полный доступ ко всем возможностям</span>
	    </div>
	    <div class="b-reg-now__buttons">
		<a href="#"
		   class="button regstep" 
		   data-url="<?= Url::toRoute(['registration/step1', 'type' => User::TYPE_USER_USER]) ?>">Я пользователь</a>
		<a href="#" 
		   class="button regstep"
		   data-url="<?= Url::toRoute(['registration/step1', 'type' => User::TYPE_USER_COMPANY]) ?>">Я компания</a>
	    </div>
	</div>
    </div>
</div>
<!-- end b-reg-now -->

<!-- begin b-last-users -->
<?= LatestUsersAddWidget::widget(); ?>
<!-- end b-last-users -->
