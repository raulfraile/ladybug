# Extending

Ladybug is built in a modular way using the `DependencyInjection` Symfony2 component. Overriding
or adding new behaviour is as easy as adding new services.

## Basics

There are 6 components

* Themes: Used to render
* Inspector:
* Metadata
* Type
* Render

To include any of these, you must create a new `extension` and include them inside.

## Extension

An extension encapsulates one or more components and it must have a class implementing the `ExtensionInterface` interface.
So, if you want to create a new theme, you will have to create the extension first and then the theme:

/CoolExtension
    CoolExtension.php (implements ExtensionInterface)
    Config/
        services.xml
    Theme/
        CoolTheme/
           ...
    ...



### Themes

### Inspectors

Finally, include the service in the `MyExtension\Config\services.xml` file.

``` xml
<service id="myextension_inspector_php" class="CoolExtension\Inspector\XyzMetadata">
    <tag name="ladybug.inspector" />
</service>
```

### Metadatas

Metadatas detect some predefined classes based only in the fully qualified name, in order to
display the icon, version and the help link.

The metadata class must implement the `MetadataInterface` interface, which has only two methods:
`hasMetadata($className)` and `getMetadata($className)`. It must return an array with the keys `icon`,
`help_link` and `version`.

For example,

``` php
class SymfonyMetadata
{
    const URL = 'http://api.symfony.com/%version%/index.html?q=%class%';

    public function hasMetadata($class)
    {
        return preg_match('/^Symfony\\\/', $class) === 1;
    }

    public function getMetadata($class)
    {
        if ($this->hasMetadata($class)) {
            return array(
                'help_link' => str_replace(array('%version%', '%class%'), array('2.3', urlencode($class)), static::URL),
                'icon' => self::ICON,
                'version' => '2.3'
            );
        }

        return array();
    }

}
```

Finally, include the service in the `MyExtension\Config\services.xml` file.

``` xml
<service id="coolextension_metadata_php" class="CoolExtension\Metadata\XyzMetadata">
    <tag name="ladybug.metadata" />
</service>
```

### Types


### Renders