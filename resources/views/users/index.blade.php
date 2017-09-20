<?php foreach($users as $user):?>
    <div>
        <p><b>Username:</b> {{ $user->co_usuario }}</p>
        <p><b>Nombre:</b> {{ $user->no_usuario }}</p>
    </div>
    <br>
<?php endforeach; ?>