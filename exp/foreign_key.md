# Foreign key

## 1. Cos’è una foreign key?

Una foreign key è una colonna in una tabella che collega i dati a un’altra tabella. Serve per creare relazioni tra tabelle, come "un utente ha molti post" o "un post appartiene a un utente". Garantisce che i dati siano coerenti (es. non puoi inserire un post con un ID utente che non esiste).

## 2. Esempio pratico

Immaginiamo due tabelle:

-   **users**: Ha una colonna `id` (chiave primaria).
-   **posts**: Ha una colonna `user_id` (chiave esterna) che si collega all’`id` di `users`.

## 3. Crea le migrations

### Tabella users

Se non l’hai già, crea la migration per `users`:

```bash
php artisan make:migration create_users_table
```

Modifica il file generato (`database/migrations/xxx_create_users_table.php`):

```php
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Chiave primaria
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('users');
}
```

### Tabella posts con foreign key

Crea una nuova migration:

```bash
php artisan make:migration create_posts_table
```

Modifica il file (`database/migrations/xxx_create_posts_table.php`):

```php
public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id(); // Chiave primaria
        $table->string('title');
        $table->text('content');
        $table->unsignedBigInteger('user_id'); // Colonna per la foreign key
        $table->timestamps();

        // Definizione della foreign key
        $table->foreign('user_id')->references('id')->on('users');
    });
}

public function down()
{
    Schema::dropIfExists('posts');
}
```

-   `unsignedBigInteger('user_id')`: Crea una colonna `user_id` dello stesso tipo di `id` in `users` (che è un `bigInteger` senza segno).
-   `foreign('user_id')->references('id')->on('users')`: Dice che `user_id` è una foreign key che punta alla colonna `id` della tabella `users`.

## 4. Lancia le migrations

Esegui:

```bash
php artisan migrate
```

Prima crea la tabella `users` (perché la foreign key ha bisogno che `users` esista già).

Poi crea `posts` con la foreign key.

**Nota**: Se hai un errore perché `posts` viene prima di `users`, modifica i timestamp nei nomi dei file migration (es. `2023_03_11_100000_create_users_table.php` prima di `2023_03_11_100001_create_posts_table.php`).

## 5. Cosa fa la foreign key?

-   **Integrità**: Non puoi inserire un post con un `user_id` che non esiste in `users`.
-   **Relazione**: Collega ogni post a un utente specifico.

## 6. Opzioni utili per la foreign key

Puoi aggiungere comportamenti alla foreign key:

-   **Eliminazione a cascata**: Se un utente viene eliminato, elimina anche i suoi post.
    ```php
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    ```
-   **Imposta a NULL**: Se un utente viene eliminato, imposta `user_id` a NULL.
    ```php
    $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
    ```
    (In questo caso, `user_id` deve essere nullable: `$table->unsignedBigInteger('user_id')->nullable();`).

## 7. Rollback con foreign key

Se fai:

```bash
php artisan migrate:rollback
```

Laravel elimina prima `posts` (perché ha la foreign key) e poi `users`.

Se hai problemi, usa `migrate:fresh` per ripartire da zero.

## Riassunto

-   **Foreign key**: Collega una colonna (es. `user_id`) a una chiave primaria di un’altra tabella (es. `id` di `users`).
-   **Migration**: Usa `unsignedBigInteger` e `foreign()` per definirla.
-   **Opzioni**: Aggiungi `onDelete('cascade')` o `onDelete('set null')` se serve.
