# Passare Dati alla View in Laravel

## Passo 1: La rotta (dove vive la pagina)

In Laravel, le "rotte" decidono cosa succede quando vai su un indirizzo tipo www.miosito.com/staff. Le rotte si scrivono nel file `routes/web.php`. Apri quel file (è nella cartella principale del progetto) e aggiungi questa riga:

```php
use App\Http\Controllers\PagesController;

Route::get('/staff', [PagesController::class, 'staff']);
```

**Spiegazione**

-   `Route::get('/staff', ...)` significa: "Se qualcuno scrive /staff nel browser, fai qualcosa".
-   `[PagesController::class, 'staff']` dice: "Vai a cercare una scatola chiamata PagesController e usa la funzione staff che c’è dentro".
-   `use App\Http\Controllers\PagesController;` è come dire: "Ehi, Laravel, sappi che questa scatola si trova nella cartella Controllers".

## Passo 2: Crea la scatola (il Controller)

Il "controller" è come un cuoco che prepara i dati e li passa al cameriere (la view). Creiamolo! Nel terminale, scrivi:

```bash
php artisan make:controller PagesController
```

Questo crea un file chiamato `PagesController.php` nella cartella `app/Http/Controllers`. Aprilo e scriviamo qualcosa dentro:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Non ci serve ora, ma è normale averlo

class PagesController extends Controller
{
    public function staff()
    {
        // Preparo i dati
        $titolo = "Il nostro staff"; // Un semplice testo
        $staff = [
            ['nome' => 'Mario'],
            ['nome' => 'Luigi'],
            ['nome' => 'Peach']
        ]; // Una lista di persone (finta, per ora)

        // Passo i dati alla pagina "staff"
        return view('pages.staff', [
            'titolo' => $titolo,
            'staff' => $staff
        ]);
    }
}
```

**Spiegazione:**

-   `class PagesController` è la scatola che contiene le istruzioni.
-   `public function staff()` è una funzione (un pulsante) che si attiva quando vai su /staff.
-   `$titolo = "Il nostro staff";` è un pezzo di testo che voglio mostrare.
-   `$staff = [...]` è una lista di persone inventate (ogni persona è un "pacchetto" con un nome).
-   `return view('pages.staff', [...])` significa: "Prendi la pagina chiamata staff nella cartella pages e dagli questi dati (titolo e staff) da usare".

## Passo 3: Crea la pagina (la View)

La "view" è il foglio HTML che mostra i dati. Le view vivono nella cartella `resources/views`. Dentro questa cartella, crea una sottocartella chiamata `pages` (se non c’è già), e dentro `pages` crea un file chiamato `staff.blade.php`. Apri `staff.blade.php` e scrivi:

```html
<!DOCTYPE html>
<html>
    <head>
        <title>{{ $titolo }}</title>
    </head>
    <body>
        <h1>{{ $titolo }}</h1>
        <p>Ecco chi lavora qui:</p>
        <ul>
            @foreach ($staff as $persona)
            <li>{{ $persona['nome'] }}</li>
            @endforeach
        </ul>
    </body>
</html>
```

**Spiegazione:**

-   `<!DOCTYPE html>` e il resto è il normale HTML per fare una pagina web.
-   `{{ $titolo }}` è come un buco magico: ci finisce dentro il testo "Il nostro staff" che abbiamo mandato dal controller.
-   `@foreach ($staff as $persona)` significa: "Prendi la lista $staff e per ogni persona dentro la lista, chiamala $persona e fai qualcosa".
-   `<li>{{ $persona['nome'] }}</li>` dice: "Per ogni persona, stampa il suo nome (es. Mario, Luigi, Peach) in un elenco".
-   `@endforeach` chiude il ciclo, come dire "ho finito con la lista".

## Passo 4: Provalo!

Avvia il server di Laravel dal terminale:

```bash
php artisan serve
```

Apri il browser e vai a: `http://localhost:8000/staff`.

Se tutto è andato bene, vedrai:

```
Il nostro staff
Ecco chi lavora qui:
- Mario
- Luigi
- Peach
```

## BONUS: Usare dati veri dal database

Se vuoi prendere i dati da un database (tipo una tabella `users`), devi:

-   Avere una tabella `users` nel database (Laravel ne crea una di default con `php artisan migrate`).
-   Modificare il controller così:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User; // Aggiungo questo per usare il modello User

class PagesController extends Controller
{
    public function staff()
    {
        $titolo = "Il nostro staff";
        $staff = User::all(); // Prendo tutti gli utenti dal database

        return view('pages.staff', [
            'titolo' => $titolo,
            'staff' => $staff
        ]);
    }
}
```

E nella view, cambia `$persona['nome']` in `$persona->name`, perché i dati dal database sono oggetti, non array:

```html
<li>{{ $persona->name }}</li>
```

**Spiegazione "da tonto":**

-   `User::all()` è come dire: "Vai nel database, prendi tutti gli utenti e mettili in $staff".
-   `$persona->name` significa: "Per ogni utente, prendi il suo nome dalla colonna name della tabella".

## Riassunto finale

-   **Rotta:** Scrivi in `web.php` dove vive la pagina (/staff).
-   **Controller:** Prepara i dati (es. `$titolo` e `$staff`) e spediscili alla view con `view('pages.staff', [...])`.
-   **View:** Usa `{{ $variabile }}` per mostrare un dato e `@foreach` per fare una lista.

Se vai su `/staff` e non funziona, controlla:

-   Hai scritto tutto giusto?
-   Il server è acceso?
-   La cartella `pages` e il file `staff.blade.php` esistono?
