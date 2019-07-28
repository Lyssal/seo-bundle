# The Lyssal SEO bundle


The Lyssal SEO bundle permits you to use the Page entity for all your URLs and SEO informations (as title, description, author, etc ; see the Page and Website properties).

The slugs are automatically generated and you can use the Twig templates to autoamtically generate the meta tags.


## Installation

Read the [installation documentation](doc/Installation.md).


## How to use

Read the [How to use documentation](doc/HowToUse.md).


## The sitemap.xml

Read the [sitemap documentation](doc/Sitemap.md).


## About properties

Read the [properties documentation](doc/Properties.md).


## Automatically get the Page entity

For performance reason, the Page entity property is null by default but you can change this behavior by copy this code in your `services.yaml`:

```yaml
Lyssal\SeoBundle\EventListener\PageEntityGetter:
    tags:
        - { name: 'doctrine.event_listener', event: 'postLoad' }
```


## EasyAdmin

If you use EasyAdmin, please read the [EasyAdmin documentation](doc/EasyAdmin.md).


## PhpDoc

Execute :

```sh
phpdoc -c doc/phpdoc.tpl.xml
```
