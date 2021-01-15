<div class="formWrapper">
    <div>
        <div class="confirmTable">
            <div class="tableRow head">
                <div class="tableCell">LoginID</div>
                <div class="tableCell center">Vorname</div>
                <div class="tableCell center">Nachname</div>
                <div class="tableCell center">Rolle</div>
                <div class="tableCell center">Validated</div>
                <div class="tableCell center">Enabled</div>
                <div class="tableCell center">Passwort zurücksetzen</div>
                <div class="tableCell center">Bestätigung</div>
            </div>

            <?php foreach($logins as $login) : ?>
                <form method="post" action="?c=accounts&a=adminusermanagement">
                    <div class="tableRow">
                        <input id="user" name="user" class="tableCell" value="<?=htmlspecialchars($login->user->id)?>" </input>

                        <div class="tableCell center"><?=htmlspecialchars($login->user->firstName)?></div>
                        <div class="tableCell center"><?=htmlspecialchars($login->user->lastName)?></div>
                        <div class="tableCell center">
                            <select name="role">
                                <option value="admin"
                                    <?= ($login->user->role === 'admin') ? 'selected' : '' ?>
                                >Admin</option>
                                <option value="user"
                                    <?= ($login->user->role === 'user') ? 'selected' : '' ?>
                                >Nutzer</option>
                            </select>
                        </div>
                        <div class="tableCell center">
                            <select name="validated">
                                <option value="1"
                                    <?= ($login->validated) ? 'selected' : '' ?>
                                >validated</option>
                                <option value="0"
                                    <?= ($login->validated) ? '' : 'selected' ?>
                                >unvalidated</option>
                            </select>
                        </div>
                        <div class="tableCell center">
                            <select name="enabled">
                                <option value="1"
                                    <?= ($login->enabled) ? 'selected' : '' ?>
                                >enabled</option>
                                <option value="0"
                                    <?= ($login->enabled) ? '' : 'selected' ?>
                                >disabled</option>
                            </select>
                        </div>
                        <div class="tableCell center">
                            <div> <input type="checkbox" id="passwordReset" name="passwordReset" > </div>
                        </div>
                        <div class="tableCell center">
                            <button class="buttonForAll" type="submit" name="saveChanges">Änderung Speichern</button>
                        </div>
                    </div>
                <!--<input type="hidden" id="user" name="user" value="<?/*= $login->user->id */?>">-->
                </form>
            <?php endforeach ?>
        </div>
</div>





        <? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>

