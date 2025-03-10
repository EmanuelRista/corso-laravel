# Creare una View in Laravel

## 1. Crea il Controller

Il controller è come il "cervello" che gestisce la logica e dice alla rotta cosa mostrare. Apri il terminale (o la linea di comando) nella cartella del tuo progetto Laravel.

Usa questo comando Artisan per creare un controller chiamato, ad esempio, `PageController`:

```bash
php artisan make:controller PageController
```

Questo creerà un file chiamato `PageController.php` nella cartella `app/Http/Controllers`.

Apri il file `PageController.php` e aggiungi una funzione (metodo) che dirà alla rotta cosa fare. Per esempio:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showHome():View
    {
        return view('home');
    }
}
```

Qui, `showHome` è il nome della funzione che collega la rotta alla view chiamata `home`.

## 2. Crea la View

La view è il file che contiene l’HTML, cioè quello che l’utente vedrà nel browser. Vai nella cartella `resources/views`.

Crea un nuovo file chiamato `home.blade.php` (il `.blade.php` è importante perché Laravel usa il motore Blade per le viste).

Apri il file e metti qualcosa di semplice, tipo:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>La mia prima pagina</title>
    </head>
    <body>
        <h1>Ciao! Questa è la mia home page!</h1>
    </body>
</html>
```

Salva il file. Questo sarà ciò che vedrai quando visiterai la rotta.

## 3. Crea la Rotta

La rotta è come l’indirizzo web (URL) che collega il browser al controller. Vai al file `routes/web.php`.

Aggiungi questa riga per creare una rotta che punta alla funzione del controller:

```php
use App\Http\Controllers\PageController;

Route::get('/home', [PageController::class, 'showHome']);
```

`Route::get` significa che questa rotta risponde a una richiesta GET (cioè quando visiti un URL).

`/home` è l’URL che digiterai nel browser (es. `http://localhost:8000/home`).

`[PageController::class, 'showHome']` dice a Laravel di usare la funzione `showHome` del `PageController`.

## 4. Prova Tutto

Ora vediamo se funziona! Assicurati che il tuo server Laravel sia attivo. Nel terminale, nella cartella del progetto, usa:

```bash
php artisan serve
```

Questo avvia il server locale, di solito su `http://localhost:8000`.

Apri il browser e vai a `http://localhost:8000/home`.

Se tutto è fatto bene, vedrai la tua pagina con il messaggio “Ciao! Questa è la mia home page!”.
