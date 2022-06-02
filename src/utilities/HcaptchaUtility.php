<?php
/**
 * craft-hcaptcha plugin for Craft CMS 3.x
 *
 * Integrate hCAPTCHA validation into your forms.
 *
 * @link      https://c10d.dev
 * @copyright Copyright (c) Cédric Givord
 */

namespace c10d\crafthcaptcha\utilities;

use c10d\crafthcaptcha\CraftHcaptcha;
use c10d\crafthcaptcha\records\HcaptchaLogs;

use Craft;
use craft\base\Utility;

/**
 * Craft hCAPTCHA Utility
 *
 * @author    Cédric Givord
 * @package   CraftHcaptcha
 * @since     1.2.0
 */
class HcaptchaUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return 'hCAPTCHA';
    }

    /**
     * @inheritdoc
     */
    public static function id(): string
    {
        return 'hcaptcha';
    }

    /**
     * @inheritdoc
     */
    public static function iconPath()
    {
        return Craft::getAlias("@c10d/crafthcaptcha/icon.svg");
    }

    /**
     * @inheritdoc
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public static function contentHtml(): string
    {
        $total = HcaptchaLogs::find()->count();
        $success = $total > 0 ? round((HcaptchaLogs::find()->where(['success' => 1])->count() / $total) * 100) : 0;
        $failure = $total > 0 ? round((HcaptchaLogs::find()->where(['success' => 0])->count() / $total) * 100) : 0;
        $logs = HcaptchaLogs::find()->where(['not', ['requestUrl' => null]])->orderBy('dateCreated desc')->limit(10)->all();
        return Craft::$app->getView()->renderTemplate(
            'craft-hcaptcha/utility',
            [
                'total' => $total,
                'success_rate' => $success,
                'failure_rate' => $failure,
                'logs' => $logs,
            ]
        );
    }
}
