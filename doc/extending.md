# Extending

Ladybug is built in a modular way and allows adding plugins with extra behaviour really easily.

## Basics

The library is composed of six main components:

* Helpers: Functions to dump variables more easily (e.g. ladybug_dump_die($var))
* Themes: Themes render one or more variables in a specific format.
* Inspectors: An inspector is responsible of adding any extra information to an object/resource. For example, the
there is an inspector to display the \SplMaxHeap elements as a collection.
* Metadatas: Metadatas return meta-information such as the documentation link for a given object/resource. For example,
 there are inspectors to detect Symfony objects, so the themes can render a Symfony icon next to the class name.
* Type: Variable types. There are 'native' types like `float` or `string`, as well as extended types such as `collection`, `image` or `code.
* Renderers: Renderers handle the render process for a given format and theme.

To include any of these, you must create a new `plugin` and include them inside.

## Plugin

A plugin encapsulates one or more components and must have a class implementing the `PluginInterface` interface.
So, if you want to create a new metadata class to detect Symfony classes, you will have to create the plugin
 first and then the metadata:

/CoolPlugin
    CoolPlugin.php (implements PluginInterface)
    Config/
        services.xml
    Metadata/
        SymfonyMetadata.php
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


***

Next section: [Reference](https://github.com/raulfraile/ladybug/blob/master/doc/reference.md).

Previous section: [Examples](https://github.com/raulfraile/ladybug/blob/master/doc/examples.md).