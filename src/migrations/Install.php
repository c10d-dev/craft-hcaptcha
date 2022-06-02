<?php
/**
 * craft-hcaptcha plugin for Craft CMS 3.x
 *
 * Integrate hCAPTCHA validation into your forms.
 *
 * @link      https://c10d.dev
 * @copyright Copyright (c) Cédric Givord
 */

namespace c10d\crafthcaptcha\migrations;

use c10d\crafthcaptcha\CraftHcaptcha;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * @author    Cédric Givord
 * @package   CraftHcaptcha
 * @since     1.2.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

   /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%crafthcaptcha_logs}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%crafthcaptcha_logs}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                    'siteId' => $this->integer()->notNull(),
                    'success' => $this->boolean()->notNull()->defaultValue(false),
                    'requestUrl' => $this->mediumText(),
                    'requestBody' => $this->longText(),
                    'captchaJson' => $this->mediumText(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * @return void
     */
    protected function createIndexes()
    {
        $this->createIndex(
            $this->db->getIndexName(
                '{{%crafthcaptcha_logs}}',
                'success',
                false
            ),
            '{{%crafthcaptcha_logs}}',
            'success',
            false
        );
        $this->createIndex(
            $this->db->getIndexName(
                '{{%crafthcaptcha_logs}}',
                'requestUrl',
                false
            ),
            '{{%crafthcaptcha_logs}}',
            'requestUrl(40)',
            false
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * @return void
     */
    protected function addForeignKeys()
    {
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%crafthcaptcha_logs}}', 'siteId'),
            '{{%crafthcaptcha_logs}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * @return void
     */
    protected function removeTables()
    {
        $this->dropTableIfExists('{{%crafthcaptcha_logs}}');
    }
}
