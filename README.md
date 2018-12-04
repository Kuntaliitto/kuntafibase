# Composer template for Drupal KuntafiBase projects

This project template should provide a kickstart for managing your site
dependencies with [Composer](https://getcomposer.org/).

## Usage

First you need to install [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) and [Git](https://git-scm.com).

> Note: The instructions below refer to the [global composer installation](https://getcomposer.org/doc/00-intro.md#globally).
You might need to replace `composer` with `php composer.phar` (or similar)
for your setup.

After that you can create the project:

```
composer create-project burdamagazinorg/thunder-project ProjectToWorkWith --stability dev --no-interaction
```

With `composer require ...` you can download new dependencies to your
installation.

```
cd ProjectToWorkWith
```

The `composer create-project` command passes ownership of all files to the
project that is created. You should create a new git repository, and commit
all files not excluded by the .gitignore file.

````
git init
Initialized empty Git repository in /ProjectToWorkWith/.git/
````

Add `KuntafiBase` as dependency

```
composer require kuntaliitto/kuntafibase:8.x.6.x-dev
```



## What does the template do?

When installing the given `composer.json` some tasks are taken care of:

* Drupal will be installed in the `docroot`-directory.
* Autoloader is implemented to use the generated composer autoloader in `vendor/autoload.php`,
  instead of the one provided by Drupal (`docroot/vendor/autoload.php`).
* Modules (packages of type `drupal-module`) will be placed in `docroot/modules/contrib/`
* Theme (packages of type `drupal-theme`) will be placed in `docroot/themes/contrib/`
* Profiles (packages of type `drupal-profile`) will be placed in `docroot/profiles/contrib/`
* Downloads Drupal scaffold files such as `index.php`, or `.htaccess`
* Creates `sites/default/files`-directory.
* Latest version of drush is installed locally for use at `bin/drush`.
* Latest version of DrupalConsole is installed locally for use at `bin/drupal`.

## Installing `KuntafiBase`

Create project will install `KuntafiBase` into the `docroot/profiles/contrib` directory inside of `ProjectToWorkWith`. You can now install `KuntafiBase` as you would with any Drupal 8 site. See: [Drupal installation guide](https://www.drupal.org/node/1839310).

There might be some cotchas during installation and it might fail to finnish. It is *new feature to Drupal* [handle installations based on another distribution](https://www.drupal.org/node/1356276). [Manual installation is documented](#manual) in this document later.

## Updating `KuntafiBase`

This project will attempt to keep all of your `ProjectToWorkWith` and Drupal Core files up-to-date; the
project [drupal-composer/drupal-scaffold](https://github.com/drupal-composer/drupal-scaffold)
is used to ensure that your scaffold files are updated every time drupal/core is
updated. If you customize any of the "scaffolding" files (commonly .htaccess),
you may need to merge conflicts if any of your modfied files are updated in a
new release of Drupal core.

Follow the steps below to update your `KuntafiBase` files.

1. Run `composer update kuntaliitto/kuntafibase:8.x.6.x-dev`
1. Run `git diff` to determine if any of the scaffolding files have changed.
   Review the files for any changes and restore any customizations to
  `.htaccess` or `robots.txt`.
1. Commit everything all together in a single commit, so `docroot` will remain in
   sync with the `core` when checking out branches or running `git bisect`.
1. In the event that there are non-trivial conflicts in step 2, you may wish
   to perform these steps on a branch, and use `git merge` to combine the
   updated core files with your customized files. This facilitates the use
   of a [three-way merge tool such as kdiff3](http://www.gitshah.com/2010/12/how-to-setup-kdiff-as-diff-tool-for-git.html). This setup is not necessary if your changes are simple;
   keeping all of your modifications at the beginning or end of the file is a
   good strategy to keep merges easy.

## Updating Thunder

`KuntafiBase` is based on Thunder -distribution. We use it as base and extend its structure. This said, our `ProjectToWorkWith` needs to keep eye on [`Thunder` releases](https://github.com/BurdaMagazinOrg/thunder-distribution/releases) too.

in composer.json edit the line:
`
  "burdamagazinorg/thunder": "~8.2",
`
and run `composer update burdamagazinorg/thunder`



## FAQ

### Should I commit the contrib modules I download

Composer recommends **no**. They provide [argumentation against but also
workrounds if a project decides to do it anyway](https://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).

### How can I apply patches to downloaded modules?

If you need to apply patches (depending on the project being modified, a pull
request is often a better solution), you can do so with the
[composer-patches](https://github.com/cweagans/composer-patches) plugin.

To add a patch to drupal module foobar insert the patches section in the extra
section of composer.json:
```json
"extra": {
    "patches": {
        "drupal/foobar": {
            "Patch description": "URL to patch"
        }
    }
}
```

### How can I prevent downloading modules from Thunder, that I do not need?

To prevent downloading a module, that Thunder provides but that you do not need, add a replace block to your composer.json:

```json
"replace": {
    "burdamagazinorg/infinite_theme": "*",
    "burdamagazinorg/infinite_module": "*",
    "drupal/ivw_integration": "*",
    "drupal/nexx_integration": "*",
    "drupal/riddle_marketplace": "*",
    "valiton/harbourmaster": "*",
    "drupal/adsense": "*",
    "drupal/liveblog": "*"
}
```

This example prevents any version of the feature module to be downloaded.

### <a id="manual"></a>Manual installation

##### Installaatio failed debug

http://localhost:8080/core/install.php?profile=kuntafibase&langcode=en

```
An AJAX HTTP error occurred.
HTTP Result Code: 200
Debugging information follows.
Path: /core/install.php?profile=kuntafibase&langcode=en&id=1&op=do_nojs&op=do
StatusText: OK
ResponseText: Drupal\Core\Config\UnmetDependenciesException: 

Configuration objects provided by <em class="placeholder">thunder</em> have unmet dependencies: 
<em class="placeholder">block.block.thunder_base_account_menu (thunder_base)</em> in Drupal\Core\Config\UnmetDependenciesException::create() (line 98 of /var/www/html/docroot/core/lib/Drupal/Core/Config/UnmetDependenciesException.php).
```

```
drush cim --partial --source="profiles/contrib/thunder/config/install"
drush cim --partial --source="profiles/contrib/thunder/config/optional"
```

```
drush config-delete blazy.settings
drush config-delete shariff.settings
drush config-delete paragraphs_features.settings
```

```
drush en blazy
drush en shariff
drush en paragraphs_features
```

```
drush en thunder_article thunder_media thunder_paragraphs thunder_taxonomy thunder_updater -y
```

```
drush then thunder_base -y
drush then thunder_admin -y
```

```
drush cim --partial --source="profiles/contrib/kuntafibase/config/install" -y
```

```
drush en kuntafibase_core kuntafibase_basic_article kuntafibase_contacts, kuntafibase_basic_page -y
```

```
drush en kuntafibase_now kuntafibase_paragraphs kuntafibase_blog kuntafibase_book -y
```
