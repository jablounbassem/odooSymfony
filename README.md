# OdooConnectorBundle

A Symfony Client for Odoo using Ripcord RPC library (as used in Odoo Web API docs)


## Installation

* Download OdooConnectorBundle using [composer]()

```composer
composer require sofia-holding/odoo-connector-bundle
```
* Enable the Bundle
```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
            new \Odoo\ConnectorBundle\OdooConnectorBundle(),
        // ...
    );
}
```

*Configure your application's parametrers.yml
```yml
# app/config/parameters.yml


    url_odoo:  'example.odoo.com'
    db_odoo: "example-database"
    username_odoo: "user@email.com"
    password_odoo: "yourpassword"
```
Configure the assets
Import OdooConnectorBundle routing
```bash
pip install foobar
```

## Usage

```python
import foobar

foobar.pluralize('word') # returns 'words'
foobar.pluralize('goose') # returns 'geese'
foobar.singularize('phenomena') # returns 'phenomenon'
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
