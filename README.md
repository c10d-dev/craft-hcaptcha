# hCAPTCHA plugin for Craft CMS

Integrate hCAPTCHA validation into your forms.


## Requirements

This plugin requires Craft CMS 3.4 or later.


## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require c10d/craft-hcaptcha

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for craft-hcaptcha.


## Configuring craft-hcaptcha

1. [Sign up for hCAPTCHA API key](https://dashboard.hcaptcha.com).
2. Open the Craft admin and go to Settings → Plugins → Craft hCAPTCHA → Settings.
3. Add your `site key` and `secret key`, then save.
4. Add the hCAPTCHA template tag and js to your forms.


## Using craft-hcaptcha

In your template, just add the following twig snippet to render the hCAPTCHA iframe:

```twig
{{ craft.hcaptcha.render() }}
```

Or you can change the id of the container, and set some options:

```twig
{{ craft.hcaptcha.render('hcap', { 'theme': 'dark' }) }}
```

If you're using a modal or for any reason the hcaptcha div is not in the DOM when the page is loaded, you could set a trigger when the block becomes visible (the js file should be already loaded):

```twig
{{ craft.hcaptcha.render('hcaptcha-1', { 'size': 'compact' }) }}
<style onload="hcaptcha.render('hcaptcha-1');"></style>
```

You can even create the block yourself and only get the site key variable:

```twig
<div class="h-captcha" data-sitekey="{{ craft.hcaptcha.sitekey() }}"></div>
<script src="https://hcaptcha.com/1/api.js" async defer></script>
```

If you want to know what options are available, see the [hCAPTCHA documentation](https://docs.hcaptcha.com/configuration).

NOTE: After this step is done, if you’re using the CraftCMS [Contact Form](https://plugins.craftcms.com/contact-form) plugin or you're using craft-hcaptcha to validate a public user registration, just activate the corresponding toggle in the plugin's settings, you're all set! (the hcaptcha will be automatically verified on submission)


## Verify the hCAPTCHA

On the server side, you can use this to verify that the hCAPTCHA was done:

```php
use c10d\crafthcaptcha\CraftHcaptcha;

// [ ... ]

$captcha = Craft::$app->getRequest()->getParam('h-captcha-response');
$isValid = CraftHcaptcha::$plugin->hcaptcha->verify($captcha);
if (!$isValid) {
    // ERROR: you can push an error here
}
```


---

Brought to you by [Cédric Givord](https://c10d.dev)
