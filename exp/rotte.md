# Laravel Routes

## Cosa sono le rotte in Laravel?

Le rotte sono il modo in cui Laravel capisce "dove" mandare l'utente quando visita una pagina o fa una richiesta al tuo sito (ad esempio, cliccando un link o inviando un modulo). In pratica, le rotte collegano un URL (come www.tuosito.com/contatti) a un'azione specifica, come mostrare una pagina o elaborare dei dati.

Pensa alle rotte come a un vigile urbano: l’URL è la strada che l’utente vuole prendere, e la rotta dice al traffico (la richiesta) dove andare (il codice da eseguire).

## Dove si trovano le rotte?

In Laravel, le rotte sono definite in file specifici nella cartella `routes`. I più importanti sono:

-   `routes/web.php`: Qui metti le rotte per le pagine web (quelle che restituiscono HTML, come una homepage o un form).
-   `routes/api.php`: Qui metti le rotte per le API (quelle che restituiscono dati, come JSON, per app o servizi esterni).

Quando crei un nuovo progetto Laravel, `web.php` è già pronto con un esempio base.

## Come funzionano le rotte?

Ogni rotta ha tre parti principali:

-   **Metodo HTTP**: Come l’utente arriva alla rotta (es. GET per visitare una pagina, POST per inviare dati).
-   **URI (Uniform Resource Identifier)**: La parte dell’URL dopo il dominio (es. /contatti o /utente/5).
-   **Azione**: Cosa succede quando l’utente arriva lì (es. mostrare una vista o eseguire una funzione).

### Esempio base di rotta

Apri `routes/web.php` e guarda questo esempio:

```php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'Ciao, benvenuto!';
});
```

**Spiegazione passo-passo:**

-   `Route::get`: Dice a Laravel "questa è una rotta per richieste GET" (cioè quando qualcuno visita un URL nel browser).
-   `/`: Questo è l’URI. Qui significa "la homepage" (es. www.tuosito.com/).
-   `function () { return 'Ciao, benvenuto!'; }`: Questa è l’azione. Quando qualcuno visita la homepage, Laravel risponde con il testo "Ciao, benvenuto!".

Prova a visitare `http://localhost:8000` (se hai avviato `php artisan serve`) e vedrai quel messaggio!

## Tipi di metodi HTTP

Laravel supporta vari metodi HTTP, ognuno con uno scopo:

-   `Route::get()`: Per leggere dati o mostrare una pagina (es. vedere la homepage).
-   `Route::post()`: Per inviare dati (es. inviare un modulo di contatto).
-   `Route::put()`: Per aggiornare dati (es. modificare un profilo utente).
-   `Route::delete()`: Per eliminare dati (es. cancellare un post).
-   `Route::patch()`: Per aggiornamenti parziali.
-   `Route::any()`: Accetta qualsiasi metodo HTTP (meno comune).

### Esempio con POST:

```php
Route::post('/contatti', function () {
    return 'Hai inviato il modulo!';
});
```

Questa rotta risponde solo se invii dati a `/contatti` con il metodo POST (es. da un form).

## Restituire qualcosa di utile

L’azione di una rotta può restituire:

### Testo semplice:

```php
Route::get('/test', function () {
    return 'Questo è un test';
});
```

### Una vista (file HTML/PHP in `resources/views`):

Crea un file `welcome.blade.php` in `resources/views` e scrivi:

```php
Route::get('/', function () {
    return view('welcome'); // Cerca welcome.blade.php
});
```

### Dati JSON (utile per API):

```php
Route::get('/dati', function () {
    return ['nome' => 'Mario', 'età' => 30];
});
```

## Parametri nelle rotte

Spesso vuoi che l’URL abbia parti variabili, come `/utente/1` o `/utente/5`. Puoi farlo così:

```php
Route::get('/utente/{id}', function ($id) {
    return "L'utente ha l'ID: " . $id;
});
```

-   `{id}`: È un parametro. Può essere qualsiasi valore (es. 1, 5, mario).
-   `$id`: Laravel passa il valore del parametro alla funzione.

Prova a visitare `/utente/42` e vedrai "L'utente ha l'ID: 42".

### Parametri opzionali

Se un parametro può non esserci, usa `?`:

```php
Route::get('/utente/{id?}', function ($id = 'nessuno') {
    return "L'utente è: " . $id;
});
```

-   `/utente` restituisce "L'utente è: nessuno".
-   `/utente/7` restituisce "L'utente è: 7".

## Collegare le rotte ai controller

Scrivere tutto nelle rotte è scomodo per progetti grandi. Di solito, usi i controller (classi che gestiscono la logica). Ecco come:

Crea un controller con Artisan:

```sh
php artisan make:controller UtenteController
```

Troverai il file in `app/Http/Controllers/UtenteController.php`. Modificalo così:

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtenteController extends Controller
{
    public function mostra($id)
    {
        return "Utente con ID: " . $id;
    }
}
```

Collega la rotta al controller:

```php
use App\Http\Controllers\UtenteController;

Route::get('/utente/{id}', [UtenteController::class, 'mostra']);
```

Ora, visitare `/utente/10` chiama il metodo `mostra` del controller.

## Rotte con nome

Puoi dare un nome alle rotte per usarle facilmente (es. in link o redirect):

```php
Route::get('/contatti', function () {
    return 'Pagina contatti';
})->name('contatti');
```

Per generare l’URL della rotta:

```php
$url = route('contatti'); // Restituisce "/contatti"
```

## Gruppi di rotte

Se hai molte rotte con qualcosa in comune (es. un prefisso come `/admin`), usa i gruppi:

```php
Route::prefix('admin')->group(function () {
    Route::get('/utenti', function () {
        return 'Lista utenti admin';
    });
    Route::get('/impostazioni', function () {
        return 'Impostazioni admin';
    });
});
```

-   `/admin/utenti` e `/admin/impostazioni` funzionano, ma non `/utenti`.

## Middleware

I middleware sono come "filtri" per le rotte (es. controllare se l’utente è loggato). Esempio:

```php
Route::get('/segreto', function () {
    return 'Area riservata';
})->middleware('auth');
```

Solo gli utenti autenticati possono accedere a `/segreto`.

## Consigli pratici

-   Usa `php artisan route:list` per vedere tutte le rotte del tuo progetto.
-   Tieni `web.php` organizzato: usa controller e gruppi per non fare confusione.
-   Sperimenta! Cambia una rotta e prova nel browser per vedere cosa succede.
