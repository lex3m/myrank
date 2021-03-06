<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="b-modal">
    <?php
    $form = ActiveForm::begin([
		'options' => $formOptions,
		'fieldConfig' => [
		    'options' => [
			'tag' => false,
		    ],
		]
    ]);
    //$form->field($model, $attribute)->checkbox();
    ?>
    <div class="b-modal__header">
	<?= $title; ?>
    </div>
    <div class="b-modal__content">
	<?php if($message != "") { ?>
	<div class="row">
	    <div class="col-xs-12 col-sm-12" style="color:red"><?= $message ?></div>
	</div>
	<?php } ?>
	<?php foreach ($content as $key => $item) { ?>
	<div class="row" <?= isset($item['type']) && $item['type'] == 'hiddenInput' ? "style='display:none'" : "" ?>>
		<?php
		if (!isset($content[$key]['label'])) {
		    foreach ($item as $keyEl => $el) {
			$elType = $el['type'];
			?>
	    	    <div class="col-xs-12 col-sm-<?= 12 / count($item) ?>">
	    		<span><?= $el['label'] ?></span>
	    		<div <?= isset($el['divClass']) ? 'class="' . $el['divClass'] . '"' : "" ?>>
			    <?= $form->field($model, $keyEl)->$elType($el['options'])->label(FALSE); ?>
	    		</div>
			<?= isset($el['posInfo']) ? "<i>" . $el['posInfo'] . "</i>" : "" ?>
	    	    </div>
			<?php
		    }
		} else {
		    $posOpt = isset($item['posOpt']) ? $item['posOpt'] : [];
		    $itemType = $item['type'];
		    ?>
		    <div class="col-xs-12">
			<span><?= $item['label'] ?></span>
			<div <?= isset($item['divClass']) ? 'class="' . $item['divClass'] . '"' : "" ?>>
			<?php echo $form->field($model, $key)->$itemType($item['options'], $posOpt)->label(FALSE); ?>
			</div>
		    <?= isset($item['posInfo']) ? "<i>" . $item['posInfo'] . "</i>" : "" ?>
		    </div>
	    <?php } ?>
    	</div>
<?php } ?>
	<div class="row">
	    <div class="col-xs-12 col-sm-12" id="<?= $formOptions['id'] ?>Error" style="display: none; color:red;"></div>
	</div>
	<div class="b-modal__content__buttons" id="formButtons">
	    <div class="b-modal__content__buttons__item">
		<a id="<?= $formOptions['id'] ?>_save" class="button-small" href="#"><?= \Yii::t('app','SAVE'); ?></a>
	    </div>
	    <div class="b-modal__content__buttons__item">
		<span><a id="<?= $formOptions['id'] ?>_cancel" href="#"><?= \Yii::t('app','CANCEL'); ?></a></span>
	    </div>
	</div>
    </div>
<?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    $("#<?= $formOptions['id'] ?>_save").on('click', function () {
	url = "<?= $formOptions['data-url'] ?>";
	csrf = "<?= Yii::$app->request->getCsrfToken(); ?>";
	$.ajax({
	    url: url,
	    dataType: 'json',
	    data: $("#<?= $formOptions['id'] ?>").serialize(),
	    method: 'POST',
	    success: function (out) {
		if (out.code == 1) {
		    <?= $success ?>
		} else {
		    view = "";
		    $.each(out.errors, function (i, val) {
			view += val[0] + "<br/>";
		    });
		    $("#<?= $formOptions["id"] ?>Error").html(view).show("slow");
		}
	    }
	});
	return false;
    });

    $("#<?= $formOptions['id'] ?>_cancel").on('click', function () {
	$('#modalView').modal('hide');
    });

<?= $script ?>
</script>