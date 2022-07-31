@isset($users)
    @foreach($users as $user)
        <div class="m-3">
            {!! new \Orchid\Screen\Layouts\Persona($user->presenter()) !!}
        </div>
    @endforeach
@endisset
