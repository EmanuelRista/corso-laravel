# Creare un componente per il layout

## 2. Crea il file del layout

Vai nella cartella `resources/views` e crea una sottocartella chiamata `layouts` (se non esiste). Dentro, crea un file chiamato `app.blade.php`. Questo sarà il tuo layout principale.

Esempio di `resources/views/layouts/app.blade.php`:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>La mia app</title>
    </head>
    <body>
        <header>
            <h1>Benvenuto!</h1>
        </header>

        <main>@yield('content')</main>

        <footer>
            <p>Footer della mia app</p>
        </footer>
    </body>
</html>
```

`@yield('content')` è dove inserirai il contenuto specifico di ogni pagina.

## 3. Crea una pagina che usa il layout

Ora crea un file, ad esempio `resources/views/home.blade.php`, e usa il layout così:

```html
@extends('layouts.app') @section('content')
<h2>Questa è la mia homepage</h2>
<p>Contenuto personalizzato qui.</p>
@endsection
```

`@extends('layouts.app')` dice a Blade di usare il layout `app.blade.php`.

`@section('content')` definisce cosa va nello spazio `@yield('content')`.

## 4. Opzionale: Crea un componente riutilizzabile

Se vuoi un pezzo di codice ancora più modulare (es. un pulsante o una navbar), puoi creare un componente vero e proprio.
Vai su `resources/views/components/` (crea la cartella se non c’è).

Crea un file, ad esempio `button.blade.php`:

```html
<button class="btn">{{ $slot }}</button>
```

Usalo in qualsiasi vista così:

```html
<x-button>Cliccami</x-button>
```

Qui `$slot` è il contenuto che passi tra i tag `<x-button>`.

## 5. Collega tutto

Assicurati di avere una rotta nel file `routes/web.php`:

```php
Route::get('/home', function () {
    return view('home');
});
```

Ora, andando su `/home`, vedrai il layout con il contenuto della tua homepage!

## Riassunto

-   **Layout principale**: un file con `@yield` per il contenuto variabile.
-   **Pagine**: usano `@extends` e `@section` per personalizzare il layout.
-   **Componenti**: pezzi riutilizzabili con `<x-nome>`.
