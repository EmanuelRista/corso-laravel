<h1>{{ $title }}</h1>
<div>
    @foreach ($staff as $user)
        <div>
            <h1>{{ $user->name }}</h1>
            <p>{{ $user->email }}</p>
            <p>{{ $user->password }}</p>
        </div>
    @endforeach
</div>
