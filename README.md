# Imperium Clan Software - Userhelp Bundle

Userhelp management for symfony

This bundle provide javascript help for symfony with :

- [Tracelytics pageguide.js](https://tracelytics.github.io/pageguide/) for inline help

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
composer require ics/userhelp-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ics/userhelp-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    ICS\UserhelpBundle\UserhelpBundle::class => ['all' => true],
];
```

## Configuration

### Help Initialisation

Add this lines in `base.html.twig`. The code show help only if route is configured in `userhelp.yaml`

```twig
{# ... #}
{{  AddHelpCSS() }}
{% block stylesheets %}

{% endblock %}
{# ... #}
{{  AddHelpJS() }}
{% block javascripts %}

{% endblock %}
{# ... #}
{% block body %}

{% endblock %}
{{ AddHelpHtml() }}
```

### Help configuraton

Create a new file `userhelp.yaml`

```yaml
userhelp:
  helpColor: primary
  helpButtonIdentifier: helpButton
  helps:
    homepage: # route to add help
      elements:
        titlePage: # html element id
          position: bottom
          description: Title of the page # help for this element
        mainmenu:
          position: right
          description: Main menu
        homepagelink:
          position: right
          description: return to <i class="fa fa-home"></i> homepage # html is enabled in help element
```

`helpcolor` properties values are :

- primary
- secondary
- success
- warning
- danger
- info
- dark

`position` property values are :

- left
- top
- right
- bottom

### Intro Initialisation

#### Routing Installation

Intro needs route for save if user see all intro, configure `config/routes.yaml`

```yaml
# config/routes.yaml

userhelp_bundle:
  resource: "@UserhelpBundle/config/routes.yaml"
  prefix: /user/help
```

Adding js and css files to your `base.html.twig`. The code show intro only if route is configured in `userhelp.yaml`

```twig
{# base.html.twig #}
{# ... #}
{{  AddIntroCSS() }}
{% block stylesheets %}

{% endblock %}
{# ... #}
{{  AddIntroJS() }}
{% block javascripts %}

{% endblock %}
```

### Intro configuraton

Create a new file `userhelp.yaml`

```yaml
userhelp:
  introButtonIdentifier: introButton
  introTheme: modern
  intros:
    homepage: #Route name
      elements:
        pagetitle: #Element where intro step attach
          title: Page title
          description: description of the page title #Support HTML
        leftmenu:
          title: Menu of page
        mainpage:
          title: Content of page
        rightmenu:
          title: Menu of page
```

`introTheme` property values are :

- dark
- flattener
- modern
- nassim
- nazanin
- royal
