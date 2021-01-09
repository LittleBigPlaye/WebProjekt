<?php foreach($logins as $login) : ?>

    <label for="user<?=$login->id?>">LoginID: <?= $login->__get('user')->id ?></label>
    <br>
    <label for="user<?=$login->id?>">Vorname: <?= $login->__get('user')->firstName ?></label>
    <br>
    <label for="user<?=$login->id?>">Nachname: <?= $login->__get('user')->lastName ?></label>
    <br>
    <label>Auswahlfeld Rolle</label>
    <select name="validated">
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
        >enabled</option>
        <option value="2"
            <?= ($login->validated) ? '' : 'selected' ?>
        >disabled</option>
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
    <button type="submit">Änderung Speichern</button>
    <br>
    <button type="submit">Passwort für den Nutzer zurücksetzen</button>
    <hr>
<?php endforeach ?>
