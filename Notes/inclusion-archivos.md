# <h1>Separar, organizar y usar código en multiples archivos</h1>

Como usar la inclusión de archivos para mantener el código organizado, modular y mantenible

```html
<p>Conforme van creciendo las funcionalidades de nuestro software cada vez tendremos más líneas de código y no es para nada recomendable sumar miles de líneas en un solo archivo.</p>
```

```html
<p>Habrá muchas formas diferentes de separar en piezas tu código y es posible que sea complicado en un inicio.</p>

<p>Afortunadamente con PHP es muy fácil romper el código en múltiples archivos y agruparlos en diferentes directorios.</p>
```

```php
include 'dir/file1';
require 'dir/file2';
```