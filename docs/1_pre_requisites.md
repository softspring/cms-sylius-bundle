# Pre-requisites

Firstable, you need
Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

## Install cms-bundle

This bundle is an extension of https://github.com/softspring/cms-bundle

You need install cms-bundle.

### Step 1: Install extensions and dependencies

You need some PHP extensions: gd, zip, exif, fileinfo, intl, curl, mbstring. 
If you don't have, run:

```console
sudo apt-get install php{PHP-VERSION}-{PHP-EXTENSION} -y
```

For example, with PHP 8.1 and 'mbstring' PHP extension:

```console
sudo apt-get install php8.1-mbstring -y
```

Other bundles:

```console
composer require google/cloud-storage
```

### Step 2: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
composer require softspring/cms-bundle
```

### Step 3: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Softspring\CmsBundle\SfsCmsBundle::class => ['all' => true],
];
```

### Step 4: Install dependencies

```console
composer require softspring/admin-bundle
composer require softspring/components
composer require softspring/media-bundle
composer require google/cloud-storage
```

```php
// config/bundles.php

return [
    // ...
    Softspring\AdminBundle\SfsAdminBundle::class => ['all' => true],
    Softspring\Component\Components\SfsComponentsBundle::class => ['all' => true],
    Softspring\MediaBundle\SfsMediaBundle::class => ['all' => true],];
```

Create config/packages/sfs_media.yaml with your configuration
```php
// config/packages/sfs_media.yaml

sfs_media:
    google_cloud_storage:
        bucket: YOUR_BUCKET
    media:
        admin_controller: true
    types:
        ...
```

Add config/packages/sfs_cms.yaml
```php
// config/packages/sfs_cms.yaml

sfs_cms:
    collections:
        - vendor/softspring/cms-module-collection
    site:
        identification: 'domain'
        throw_not_found: false
```
Execute
```console
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```
