# Relazioni Eloquent in Laravel

## 1. Relazione Uno a Uno (One-to-One)
**Cos'è:** Un record in una tabella è collegato a un solo record in un'altra tabella.

**Esempio:** Un utente ha un solo profilo.

**Come si fa:** Nel modello `User.php` aggiungi:

```php
public function profile()
{
    return $this->hasOne(Profile::class);
}
```

E nel modello `Profile.php`:

```php
public function user()
{
    return $this->belongsTo(User::class);
}
```

**Uso:** `$user->profile` ti dà il profilo dell'utente.

## 2. Relazione Uno a Molti (One-to-Many)
**Cos'è:** Un record in una tabella è collegato a più record in un'altra tabella.

**Esempio:** Un autore scrive più libri.

**Come si fa:** Nel modello `Author.php`:

```php
public function books()
{
    return $this->hasMany(Book::class);
}
```

E nel modello `Book.php`:

```php
public function author()
{
    return $this->belongsTo(Author::class);
}
```

**Uso:** `$author->books` ti dà tutti i libri dell'autore.

## 3. Relazione Molti a Molti (Many-to-Many)
**Cos'è:** Più record di una tabella sono collegati a più record di un’altra, tramite una tabella "ponte".

**Esempio:** Uno studente segue più corsi, e un corso ha più studenti.

**Come si fa:** Nel modello `Student.php`:

```php
public function courses()
{
    return $this->belongsToMany(Course::class);
}
```

Nel modello `Course.php`:

```php
public function students()
{
    return $this->belongsToMany(Student::class);
}
```

Serve una tabella ponte (es. `course_student`) con le chiavi esterne `student_id` e `course_id`.

**Uso:** `$student->courses` ti dà i corsi dello studente.

## 4. Relazione Has Many Through
**Cos’è:** Collega una tabella a un’altra passando attraverso una tabella intermedia.

**Esempio:** Un paese ha molti post tramite gli utenti (paese → utenti → post).

**Come si fa:** Nel modello `Country.php`:

```php
public function posts()
{
    return $this->hasManyThrough(Post::class, User::class);
}
```

**Uso:** `$country->posts` ti dà i post degli utenti di quel paese.

## Concetti base
- **hasOne / hasMany:** "Io possiedo" (es. un autore possiede libri).
- **belongsTo:** "Io appartengo" (es. un libro appartiene a un autore).
- **belongsToMany:** "Siamo in tanti a essere collegati" (es. studenti e corsi).

**Chiavi:** Di default, Laravel assume che ci siano chiavi come `id` e `nomeTabella_id` (es. `user_id`), ma puoi personalizzarle.

## Esempio pratico
Immagina un blog:
- Un `User` ha molti `Post` (hasMany).
- Un `Post` appartiene a un `User` (belongsTo).

Nel codice:

```php
// Recupera tutti i post di un utente
$user = User::find(1);
$posts = $user->posts;

// Recupera l'autore di un post
$post = Post::find(1);
$author = $post->user;
```

## Libreria per relazioni avanzate
Esiste una libreria che aggiunge relazioni avanzate come `hasManyDeep` in Laravel! Si chiama "eloquent-has-many-deep" ed è stata creata da Jonas Staudenmeir. Questa libreria estende la funzionalità di `HasManyThrough` di Eloquent, permettendo di definire relazioni profonde con un numero illimitato di modelli intermedi, incluse relazioni molti-a-molti e polimorfiche.

### Dettagli della libreria
- **Nome:** staudenmeir/eloquent-has-many-deep
- **Scopo:** Aggiunge metodi come `hasManyDeep` e `hasOneDeep` per gestire relazioni complesse.
- **Installazione:** Puoi aggiungerla al tuo progetto Laravel con Composer:

```bash
composer require staudenmeir/eloquent-has-many-deep
```

### Esempio d'uso
Supponiamo di avere `Country → Users → Posts → Comments`. Nel modello `Country` puoi fare:

```php
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Country extends Model
{
    use HasRelationships;

    public function comments()
    {
        return $this->hasManyDeep(Comment::class, [User::class, Post::class]);
    }
}
```

Questo ti permette di accedere ai commenti direttamente da un paese con `$country->comments`.

### Caratteristiche principali
- Supporta relazioni concatenate attraverso più tabelle.
- Funziona con chiavi personalizzate e tabelle pivot.
- Compatibile con relazioni polimorfiche e molte altre configurazioni avanzate.
