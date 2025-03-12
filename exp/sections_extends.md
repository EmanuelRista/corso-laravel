Extends e Section

1. Cosa sono @extends e @section?
   @extends: Serve a dire a una vista (un file Blade) di "ereditare" un layout base. È come dire: "Usa questo template principale e riempilo con i miei contenuti".

@section: Definisce una "sezione" di contenuto che va a riempire una parte specifica del layout base. È come un placeholder che puoi personalizzare.

2. Come funziona un layout base
   Prima di tutto, devi avere un layout base. Ad esempio, crea resources/views/layouts/app.blade.php:
   html

<!DOCTYPE html>
<html>
<head>
    <title>La mia app</title>
</head>
<body>
    <header>
        <h1>Header fisso</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Footer fisso</p>
    </footer>

</body>
</html>

@yield('content') è il "buco" dove metterai il contenuto specifico di ogni pagina. Puoi avere più @yield (es. @yield('sidebar'), @yield('title'), ecc.).

3. Usare @extends
   Ora crea una vista che usa questo layout, ad esempio resources/views/home.blade.php:
   html

@extends('layouts.app')

@extends('layouts.app') dice: "Prendi il file app.blade.php nella cartella layouts e usalo come base".

Nota: il percorso usa i punti (.), quindi layouts.app significa resources/views/layouts/app.blade.php.

4. Usare @section
   Nella stessa vista (home.blade.php), aggiungi una sezione per riempire il @yield('content'):
   html

@extends('layouts.app')

@section('content')
<h2>Benvenuto nella homepage</h2>
<p>Questo è il contenuto della mia pagina.</p>
@endsection

@section('content') dice: "Metti questo pezzo di codice nel punto del layout dove c’è @yield('content')".

@endsection chiude la sezione.

5. Esempio con più sezioni
   Puoi avere più sezioni! Modifica il layout app.blade.php:
   html

<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
    <header>
        <h1>Header fisso</h1>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>Footer fisso</p>
    </footer>

</body>
</html>

Poi, in home.blade.php:
html

@extends('layouts.app')

@section('title')
Homepage
@endsection

@section('content')
<h2>Benvenuto nella homepage</h2>
<p>Questo è il contenuto della mia pagina.</p>
@endsection

@section('title') riempie @yield('title') nel <title> della pagina.

@section('content') riempie @yield('content') nel <main>.

6. Trucco utile: @yield con valore predefinito
   Se una sezione non viene definita, puoi dare un valore di default. Nel layout:
   html

<title>@yield('title', 'Titolo Predefinito')</title>

Se non metti @section('title') nella vista, userà "Titolo Predefinito". 7. Collega una rotta
Nel file routes/web.php:
php

Route::get('/home', function () {
return view('home');
});

Vai su /home e vedrai il layout con il contenuto della tua homepage!
Riassunto
@extends: "Usa questo layout come base".

@section: "Metti questo contenuto in una parte specifica del layout".

@yield: "Qui va il contenuto della sezione, se c’è".
