<div class="formWrapper">
    <form method="post" action="?c=accounts&a=adminusermanagement">
        <div class="confirmTable">
            <div class="tableRow head">
                <div class="tableCell">LoginID</div>
                <div class="tableCell">Vorname</div>
                <div class="tableCell">Nachname</div>
                <div class="tableCell">Rolle</div>
                <div class="tableCell">Validated</div>
                <div class="tableCell">Enabled</div>
                <div class="tableCell">Passwort zurücksetzen</div>
                <div class="tableCell">Bestätigung</div>
            </div>

            <?php foreach($logins as $login) : ?>
            <div class="tableRow">
                <input id="user" name="user" class="tableCell" value="<?=htmlspecialchars($login->user->id)?>" </input>

                <div class="tableCell"><?=htmlspecialchars($login->user->firstName)?></div>
                <div class="tableCell"><?=htmlspecialchars($login->user->lastName)?></div>
                <div class="tableCell">
                    <select name="role">
                        <option value="admin"
                            <?= ($login->user->role === 'admin') ? 'selected' : '' ?>
                        >Admin</option>
                        <option value="user"
                            <?= ($login->user->role === 'user') ? 'selected' : '' ?>
                        >Nutzer</option>
                    </select>
                </div>
                <div class="tableCell">
                    <select name="validated">
                        <option value="1"
                            <?= ($login->validated) ? 'selected' : '' ?>
                        >validated</option>
                        <option value="0"
                            <?= ($login->validated) ? '' : 'selected' ?>
                        >unvalidated</option>
                    </select>
                </div>
                <div class="tableCell">
                    <select name="enabled">
                        <option value="1"
                            <?= ($login->enabled) ? 'selected' : '' ?>
                        >enabled</option>
                        <option value="0"
                            <?= ($login->enabled) ? '' : 'selected' ?>
                        >disabled</option>
                    </select>
                </div>
                <div class="tableCell">
                    <div> <input type="checkbox" id="passwordReset" name="passwordReset" > </div>
                </div>
                <div class="tableCell">
                    <button class="buttonForAll" type="submit" name="saveChanges">Änderung Speichern</button>
                </div>
            </div>
            <!--<input type="hidden" id="user" name="user" value="<?/*= $login->user->id */?>">-->
            <?php endforeach ?>
    </form>
</div>





        <? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>

