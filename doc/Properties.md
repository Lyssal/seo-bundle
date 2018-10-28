# The SEO properties


## The entity properties

### The Host properties

Read the phpdoc for the other properties.

* **domain**

For example `http:\\my-website.fr`.
Do not forget the scheme.

* **redirectionHost**

It is to redefine a redirection on all the website pages.

You can specify the HTTP code with the `redirectionCode` property.


For example, if you want redirect all pages like `http:\\my-website.fr\slug` to `https:\\my-website.fr\slug`, create a Host with `domain` = `https:\\my-website.fr` and an other with `domain` = `http:\\my-website.fr` with a redirection to the first Host.


### The Website properties

Read the phpdoc for the other properties.

* **homePage**

Choose your home page here.

The home page slug is never used. If your URL is the host without slug (for example just `https:\\my-website.fr`), the home page will be automatically displayed.


* **byDefault**

If you have only one website, you can set this property at true without create hosts.

If a host is not found, It is the website by default which is used.


### The Page properties

Read the phpdoc for these properties.


## The Twig templates

You can call this template in your base template inside the `head` tag to automatically add the Page tags.

```yaml
{{ include('@LyssalSeo/page/_head/default_tags.html.twig') }}
```

Just this template needs to have a `page` property.
