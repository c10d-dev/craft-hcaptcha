# Craft hCAPTCHA plugin for Craft CMS 3.x

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
2. Open the Craft admin and go to Settings → Plugins → Craft reCAPTCHA → Settings.
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


---

Brought to you by [Cédric Givord](https://c10d.dev)
