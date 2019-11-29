<?php
/**
 * Custom config
 *
 * @author dandelion <web.dandelion@gmail.com>
 */

/**
 * RoboKassa
 */
define('ROBOKASSA_LOGIN','');
define('ROBOKASSA_PASS1','');
define('ROBOKASSA_PASS2','');
/**
 * QIWI
 */
define('QIWI_LOGIN','');
define('QIWI_PASSWORD','');
$qiwi_statuses = array(
    50 => 'Выставлен',
    52 => 'Проводится',
    60 => 'Оплачен',
    150 => 'Отменен (ошибка на терминале)',
    151 => 'Отменен (ошибка авторизации: недостаточно средств на балансе, отклонен абонентом при оплате с лицевого счета оператора сотовой связи и т.п.).',
    160 => 'Отменен',
    161 => 'Отменен (Истекло время)'
);
/**
 * Yandex Mail
 */
define('YANDEX_MAIL_TOKEN','f5a5a5ce7b35f5581fb15198ff180452179b2de67f219c35a93bd71e');
define('YANDEX_SMTP_LOGIN','');
define('YANDEX_SMTP_PASS','');