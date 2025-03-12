# Migrations

## 1. Cosa sono le migrations?

Le migrations sono come "istruzioni" per creare o modificare le tabelle del database. Sono file PHP che Laravel usa per gestire lo schema del database in modo ordinato e versione controllata.

## 2. Assicurati di avere un database

Prima di tutto, configura il database nel file `.env` nella root del progetto. Esempio per MySQL:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_del_tuo_db
DB_USERNAME=il_tuo_username
DB_PASSWORD=la_tua_password
```

Cambia i valori con quelli del tuo database (es. localhost o un server remoto).

Crea il database manualmente (es. con phpMyAdmin o il terminale) se non esiste ancora.

## 3. Crea una migration (se non l’hai già)

Per fare un esempio, creiamo una migration per una tabella `users`. Usa questo comando Artisan:

```bash
php artisan make:migration create_users_table
```

Questo crea un file nella cartella `database/migrations/` con un nome tipo `2023_03_11_123456_create_users_table.php`.

Apri il file generato e definisci la struttura della tabella. Esempio:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

-   `up()`: Crea la tabella quando lanci la migration.
-   `down()`: Elimina la tabella se fai un rollback.

## 4. Lancia le migrations

Ora che hai una migration, puoi eseguirla con questo comando:

```bash
php artisan migrate
```

### Cosa succede?

-   Laravel legge tutti i file in `database/migrations/` che non sono stati ancora eseguiti.
-   Crea le tabelle nel database secondo le istruzioni in `up()`.
-   Registra l’esecuzione nella tabella `migrations` (creata automaticamente nel tuo database).

Se tutto va bene, vedrai un messaggio tipo "Migrated: 2023_03_11_123456_create_users_table".

## 5. Controlla il risultato

Vai nel tuo database (es. con phpMyAdmin o un client SQL) e verifica che la tabella `users` sia stata creata con le colonne `id`, `name`, `email`, `created_at` e `updated_at`.

## 6. Opzioni utili

### Rollback (annulla l’ultima migration):

```bash
php artisan migrate:rollback
```

Esegue il metodo `down()` dell’ultima migration eseguita.

### Reset (annulla tutte le migrations):

```bash
php artisan migrate:reset
```

Rimuove tutte le tabelle create dalle migrations.

### Fresh (cancella e rilancia tutto):

```bash
php artisan migrate:fresh
```

Elimina tutte le tabelle e rilancia tutte le migrations da zero.

## 7. Problemi comuni

-   **Errore di connessione**: Controlla il file `.env` e assicurati che il database esista e le credenziali siano corrette.
-   **Tabella già esistente**: Se hai un errore, usa `migrate:fresh` per ripartire da zero (ma attento, perdi i dati!).

## Riassunto

-   Configura il database nel `.env`.
-   Crea una migration con `php artisan make:migration`.
-   Lanciala con `php artisan migrate`.
-   Usa `rollback`, `reset` o `fresh` se serve.
