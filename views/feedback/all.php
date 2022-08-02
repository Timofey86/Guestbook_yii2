<?php

/* @var $feedbackall \app\modules\admin\models\Feedback
 * @var $count integer
 */

use yii\widgets\Pjax;
use yii\bootstrap4\Html;

$this->title = Yii::t('app', 'Feedbacks');
?>

<?php Pjax::begin([
    'enablePushState' => false,
    'timeout' => 10000,
]); ?>
<?php if (!Yii::$app->user->isGuest): ?>
    <a href="add" class="btn btn-xs btn-outline-primary">Добавить отзыв</a>
<?php endif; ?>
<?php Pjax::end(); ?>
<br>
<hr>
<?php Pjax::begin([
    'enablePushState' => false,
]); ?>

<div id="feedbacks">
    <?php if (count($feedbackall) == 0): ?>
        <h3><?php echo '' ?></h3>
    <?php endif; ?>
    <?php foreach ($feedbackall as $key => $feedback): ?>
        <div>
            <?= Html::tag('p', $key + 1 . ' Автор: ' . $feedback->user->name) ?>
            <p>отзыв:<strong><?= Html::encode($feedback->message) ?> </strong></p>
            <?php $images = $feedback->images; ?>
            <?php if (!empty($images)): ?>
                <?php foreach ($images as $image): ?>
                    <ul>
                        <li><?= Html::img('/images/' . $image->name, ['width' => 150, 'height' => 120]) ?></li>
                    </ul>
                <?php endforeach; ?>
            <?php endif; ?>
            <h4><strong>Комментарии: </strong></h4>
            <p>
                <?php $comments = $feedback->comments; ?>
                <?php if (!empty($comments)) : ?>
                <?php foreach ($comments as $one): ?>
                <?= Html::tag('p', ' Автор: ' . $one->user->name) ?>
            <p>Комментарий: <strong><?= Html::encode($one->message) ?> </strong></p>
        <?php $img = $one->imgforcomments; ?>
        <?php if (!empty($img)): ?>
            <?php foreach ($img as $key): ?>
                <ul>
                    <li><?= Html::img('/images/' . $key->name, ['width' => 75, 'height' => 60]) ?></li>
                </ul>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
            <strong>
                <?php echo 'Комментарии отсутствуют :( ' ?>
            </strong>
            <br>
        <?php endif; ?>
            </p>
            <br>
            <div>
                <?php if ((\Yii::$app->authManager->checkAccess(\Yii::$app->user->id, 'admin')) || (Yii::$app->user->id == $feedback->user->id)): ?>
                    <?= Html::a('Комментировать', ['feedback/view', 'id' => $feedback->id], ['class' => 'btn btn-outline-success']) ?>
                <?php endif; ?>
            </div>
            <hr>
        </div>
    <?php endforeach; ?>
</div>
<?php Pjax::end(); ?>
<br>
<?php if (count($feedbackall) == 5): ?>
    <div class="container">
        <form class="form">
            <button class="btn btn-outline-info" id="feedback" type="submit">Получить еще отзывы</button>
        </form>
    </div>
<?php endif; ?>
<?php
$this->registerJsFile(
    '@web/js/all.js', ['depends' => 'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
]);
?>






