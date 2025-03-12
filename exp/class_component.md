# Class Component

## 1. Cos'è una Class Component?

Una class component è un componente Blade più avanzato, con una classe PHP associata. Ti permette di passare dati (come una lista di utenti) e logica al tuo template Blade in modo organizzato.

## 2. Crea il componente

Laravel ha un comando Artisan per generare un componente. Apri il terminale e scrivi:

```bash
php artisan make:component UserList
```

Questo crea:

-   Una classe PHP in `app/View/Components/UserList.php`.
-   Un file Blade in `resources/views/components/user-list.blade.php`.

## 3. Modifica la classe PHP

Apri `app/View/Components/UserList.php`. Qui definisci i dati che il componente userà. Supponiamo di voler passare un elenco di utenti. Modifica il file così:

```php
<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User; // Importa il modello User

class UserList extends Component
{
    public $users; // Variabile per gli utenti

    public function __construct($users)
    {
        $this->users = $users; // Riceve gli utenti quando il componente viene usato
    }

    public function render()
    {
        return view('components.user-list'); // Punta al file Blade
    }
}
```

`$users` sarà l’elenco degli utenti che passi al componente. `render()` dice quale file Blade usare.

## 4. Modifica il file Blade

Apri `resources/views/components/user-list.blade.php` e crea il template per mostrare gli utenti. Ad esempio:

```html
<div>
    <h2>Elenco Utenti</h2>
    <ul>
        @foreach ($users as $user)
        <li>{{ $user->name }} - {{ $user->email }}</li>
        @endforeach
    </ul>
</div>
```

`$users` viene dalla classe PHP e puoi usarlo nel Blade con un ciclo `@foreach`.

## 5. Usa il componente in una vista

Ora puoi usare il componente in qualsiasi file Blade. Ad esempio, in `resources/views/home.blade.php`:

```html
@extends('layouts.app') @section('content')
<h1>La mia pagina</h1>
<x-user-list :users="$users" />
@endsection
```

`<x-user-list>` è il tag del componente. `:users="$users"` passa una variabile `$users` dal controller alla classe del componente.

## 6. Prepara i dati nel controller

Nel tuo controller (es. `HomeController.php`), recupera gli utenti e passali alla vista:

```php
<?php

namespace App\Http\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all(); // Recupera tutti gli utenti dal database
        return view('home', ['users' => $users]);
    }
}
```

`User::all()` prende tutti gli utenti dal database (assumendo che il modello User sia configurato). Passa `$users` alla vista `home`.

## 7. Collega la rotta

Nel file `routes/web.php`, aggiungi:

```php
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
```

Ora, visitando `/home`, vedrai il layout con l’elenco degli utenti!

## Riassunto

-   **Classe**: `UserList.php` definisce i dati (es. `$users`) e il file Blade da usare.
-   **Blade**: `user-list.blade.php` mostra i dati con HTML e direttive come `@foreach`.
-   **Uso**: `<x-user-list :users="$users" />` nel Blade, con i dati dal controller.
