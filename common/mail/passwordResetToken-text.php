<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
<?= Yii::t('app', 'Hello') ?>, <?= $user->FullName ?>,

<?= Yii::t('app', 'Follow the link below to reset your password') ?>:

<?= $resetLink ?>
