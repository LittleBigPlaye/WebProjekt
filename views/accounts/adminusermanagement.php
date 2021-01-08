<?php foreach($logins as $login) : ?>

    <label for="user<?=$login->id?>">LoginID: <?= $login->__get('user')->id ?></label>
    <br>
    <label for="user<?=$login->id?>">Vorname: <?= $login->__get('user')->firstName ?></label>
    <br>
    <label for="user<?=$login->id?>">Nachname: <?= $login->__get('user')->lastName ?></label>
    <br>
    <label for="user<?=$login->id?>">Rolle: <?= $login->__get('user')->role ?></label>
    <br>
    <label for="user<?=$login->id?>">validated: <?= $login->validated ?></label>
    <br>
    <label for="user<?=$login->id?>">enabled: <?= $login->enabled ?></label>
    <br>
    <hr>
<?php endforeach ?>
