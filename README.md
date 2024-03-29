<p align="center">
    <a href="https://fm2d.com/" target="_blank">
        <img height="50" width="auto" src="https://fm2d.com/fm2d-theme/images/logo.png" alt="FM2D logo" />
        <img height="50" width="auto" src="https://demo.sylius.com/assets/shop/img/logo.png" alt="Sylius logo" />
    </a>
</p>

---
<h1 align="center">FM2D - SyliusCartBlamerPlugin</h1>

---
[![License](http://poser.pugx.org/fmdd/sylius-cart-blamer-plugin/license)](https://packagist.org/packages/fmdd/sylius-cart-blamer-plugin)
[![Latest Stable Version](http://poser.pugx.org/fmdd/sylius-cart-blamer-plugin/v)](https://packagist.org/packages/fmdd/sylius-cart-blamer-plugin) 
[![Total Downloads](http://poser.pugx.org/fmdd/sylius-cart-blamer-plugin/downloads)](https://packagist.org/packages/fmdd/sylius-cart-blamer-plugin) 
[![PHP Version Require](http://poser.pugx.org/fmdd/sylius-cart-blamer-plugin/require/php)](https://packagist.org/packages/fmdd/sylius-cart-blamer-plugin)
[![Slack](https://img.shields.io/badge/community%20chat-slack-FF1493.svg)](http://sylius-devs.slack.com)
[![Support](https://img.shields.io/badge/support-contact%20author-blue])](https://fm2d.com/contact)

FM2D is a Web Agency publisher of Sylius plugins and open source actor. Since 2016, we strive to produce useful plugins to improve your e-commerce store. FM2D also offers you a first class technical support and customer service.

---

## Summary

---

* [Overview](#overview)
* [Installation](#installation)
* [License](#license)
* [Contact](#contact)

# Overview

---

This plugin allow to your visitors to don't lost them cart if they get logged in with a non empty cart. 

# Installation

---

```bash
composer require fmdd/sylius-cart-blamer-plugin
```

* Change your config/bundles.php file to add the line for the plugin :

```php
<?php
return [
    ...
    FMDD\SyliusCartBlamerPlugin\FMDDSyliusCartBlamerPlugin::class => ['all' => true],
];
```

* Now, you can import the config file :
```yaml
#config/packages/_sylius.yaml
imports:
    ...
      - { resource: "@FMDDSyliusCartBlamerPlugin/Resources/config/config.yml"}
```

# Additional resources for developers

---
To learn more about our contribution workflow and more, we encourage you to use the following resources:
* [Sylius Documentation](https://docs.sylius.com/en/latest/)
* [Sylius Contribution Guide](https://docs.sylius.com/en/latest/contributing/)
* [Sylius Online Course](https://sylius.com/online-course/)

# License

---

This plugin's source code is completely free and released under the terms of the MIT license.

# Contact

---

If you have any questions, feel free to contact us by filling our form on [our website](https://fm2d.com/contact/) or send us an e-mail at [contact@fm2d.com](mailto:contact@fm2d.com) with your question(s). We will anwser you as soon as possible !

