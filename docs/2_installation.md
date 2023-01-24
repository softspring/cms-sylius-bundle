# Installation

## Install cms-sylius-bundle

https://github.com/softspring/cms-sylius-bundle

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require softspring/cms-sylius-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Softspring\CmsSyliusBundle\SfsCmsSyliusBundle::class => ['all' => true],
];
```

