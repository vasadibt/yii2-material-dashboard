<?php

/** @var \yii\web\View $this */

$this->title = Yii::$app->name;

$js = <<<JS
$('body').tooltip({
    selector: '[rel=tooltip]'
});
JS;
$this->registerJs($js);
?>
<div class="row">
    <div class="col-md-6">
        <button type="button" class="btn btn-secondary" rel="tooltip" data-placement="bottom" title="Tooltip on top">
            Tooltip on top
        </button>
    </div>
</div>