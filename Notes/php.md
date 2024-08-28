## Tu primer programa en php
```php
&lt;?php
echo 'Hola mundo';
```
## Combinar php con html
### Incrustar PHP dentro del HTML
```php
&lt;!DOCTYPE html&gt;
&lt;html lang="es"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;PHP Ejemplo&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;&lt;?php echo 'Hola mundo'; ?&gt;&lt;/h1&gt;
&lt;/body&gt;
&lt;/html&gt;
```
### Incrustar HTML dentro de PHP
```php
&lt;?php
echo "&lt;h1&gt;Hola mundo&lt;/h1&gt";
```