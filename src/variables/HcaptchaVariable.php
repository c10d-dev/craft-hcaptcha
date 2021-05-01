<?php
/**
 * craft-hcaptcha plugin for Craft CMS 3.x
 *
 * Integrate hCAPTCHA validation into your forms.
 *
 * @link      https://c10d.dev
 * @copyright Copyright (c) Cédric Givord
 */

namespace c10d\crafthcaptcha\variables;

use c10d\crafthcaptcha\CraftHcaptcha;

use Craft;


/**
 * craft-hcaptcha Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.hcaptcha }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    Cédric Givord
 * @package   CraftHcaptcha
 * @since     1.0.0
 */
class HcaptchaVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Render the hCAPTCHA html widget.
     *
     *     {{ craft.hcaptcha.render() }}
     *
     * @param string $id
     * @param array $options
     * @return string
     */
    public function render(string $id = 'hcaptcha-1', array $options = [])
    {
        return CraftHcaptcha::$plugin->hcaptcha->render($id, $options);
    }

    /**
     * Get the hCAPTCHA site key from settings.
     *
     *     {{ craft.hcaptcha.sitekey() }}
     *
     * @return string
     */
    public function sitekey()
    {
        $settings = CraftHcaptcha::$plugin->getSettings();
        return $settings->getSiteKey();
    }
}
