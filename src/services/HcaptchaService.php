<?php
/**
 * craft-hcaptcha plugin for Craft CMS 3.x
 *
 * Integrate hCAPTCHA validation into your forms.
 *
 * @link      https://c10d.dev
 * @copyright Copyright (c) Cédric Givord
 */

namespace c10d\crafthcaptcha\services;

use c10d\crafthcaptcha\CraftHcaptcha;

use Craft;
use craft\base\Component;
use craft\web\View;
use craft\helpers\Template;


/**
 * HcaptchaService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Cédric Givord
 * @package   CraftHcaptcha
 * @since     1.0.0
 */
class HcaptchaService extends Component
{
    protected $url = 'https://hcaptcha.com/siteverify';

    // Public Methods
    // =========================================================================

    public function render(string $id = 'hcaptcha-1', array $options = [])
    {
        $settings = CraftHcaptcha::$plugin->getSettings();

        // push hcaptcha js file at the end of the html
        Craft::$app->view->registerJsFile('https://hcaptcha.com/1/api.js?recaptchacompat=off&hl=' . Craft::$app->language);

        // override options with plugin settings
        $options['sitekey'] = $settings->getSiteKey();
        if ($settings->theme) {
            $options['theme'] = $settings->theme;
        }
        if ($settings->size) {
            $options['size'] = $settings->size;
        }

        // inject raw html
        return Template::raw(
            Craft::$app->view->renderTemplate('craft-hcaptcha/_hcaptcha', [
                'id' => $id,
                'options' => $options,
            ], View::TEMPLATE_MODE_CP)
        );
    }

    public function verify($data)
    {
        $settings = CraftHcaptcha::$plugin->getSettings();
        $params = array(
            'secret' =>  $settings->getSecretKey(),
            'response' => $data
        );

        $curlRequest = curl_init();
        curl_setopt($curlRequest, CURLOPT_URL, $this->url);
        curl_setopt($curlRequest, CURLOPT_POST, true);
        curl_setopt($curlRequest, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curlRequest, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curlRequest);
        if (!curl_errno($curlRequest)) {
            if (curl_getinfo($curlRequest, CURLINFO_HTTP_CODE) == 200) {
                $json = json_decode($response);

                if ($json->success) {
                    curl_close($curlRequest);
                    return true;
                }
            }
        }

        curl_close($curlRequest);
        return false;
    }
}
