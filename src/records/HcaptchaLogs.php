<?php
/**
 * craft-hcaptcha plugin for Craft CMS 3.x
 *
 * Integrate hCAPTCHA validation into your forms.
 *
 * @link      https://c10d.dev
 * @copyright Copyright (c) Cédric Givord
 */

namespace c10d\crafthcaptcha\records;

use c10d\crafthcaptcha\CraftHcaptcha;

use Craft;
use craft\db\ActiveRecord;

/**
 * @author    Cédric Givord
 * @package   CraftHcaptcha
 * @since     1.2.0
 */
class HcaptchaLogs extends ActiveRecord
{
    // Public Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crafthcaptcha_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null)
    {
	$tableSchema = Craft::$app->db->schema->getTableSchema('{{%crafthcaptcha_logs}}');
	if ($tableSchema) {
	    parent::save(false, $attributeNames);
	}
	return false;
    }
}
