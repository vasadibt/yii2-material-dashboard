<?php

use vasadibt\materialdashboard\helpers\Html;

?>
<footer class="footer">
    <div class="container">
        <div class="copyright">
            <?= Yii::t('materialdashboard', '&copy; {year}, made by {company}', [
                'year' => date('Y'),
                'company' => Html::a(Yii::$app->name, ['/'], ['target' => '_blank']),
            ]) ?>
        </div>
    </div>
</footer>
