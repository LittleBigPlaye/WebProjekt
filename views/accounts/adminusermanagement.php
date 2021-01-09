<?php foreach($logins as $login) : ?>
<form method="post" action="?c=accounts&a=adminusermanagement">
    <label for="user<?=$login->id?>">LoginID: <?= $login->__get('user')->id ?></label>
    <input id="user" name="user" value="<?= $login->__get('user')->id ?>" hidden>
    <br>
    <label for="user<?=$login->id?>">Vorname: <?= $login->__get('user')->firstName ?></label>
    <br>
    <label for="user<?=$login->id?>">Nachname: <?= $login->__get('user')->lastName ?></label>
    <br>
    <label>Auswahlfeld Rolle</label>
    <select name="role">
        <option value="admin"
            <?= ($login->__get('user')->role === 'admin') ? 'selected' : '' ?>
        >Admin</option>
        <option value="user"
            <?= ($login->__get('user')->role === 'user') ? 'selected' : '' ?>
        >Nutzer</option>
    </select>
    <br>
    <label>Auswahlfeld validated</label>
    <select name="validated">
        <option value="1"
            <?= ($login->validated) ? 'selected' : '' ?>
        >validated</option>
        <option value="2"
            <?= ($login->validated) ? '' : 'selected' ?>
        >unvalidated</option>
    </select>
    <br>
    <label>Auswahlfeld enabled</label>
    <select name="enabled">
        <option value="1"
            <?= ($login->enabled) ? 'selected' : '' ?>
        >enabled</option>
        <option value="2"
            <?= ($login->enabled) ? '' : 'selected' ?>
        >disabled</option>
    </select>
    <br>
    <label for="passwordReset">Passwort zurücksetzen?</label>
    <input type="checkbox" id="passwordReset" name="passwordReset" >
    <br>
    <button type="submit">Änderung Speichern</button>
    <br>
    <hr>
</form>
<?php endforeach ?>
