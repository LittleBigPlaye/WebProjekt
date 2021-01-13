


        <?php foreach($logins as $login) : ?>
        <form class="formWrapper"  method="post" action="?c=accounts&a=adminusermanagement">
            <div class="table">
                <div class="table-row">
                    <div class="table-cell">
                        <div class="table-header"> LoginID </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Vorname </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Nachname </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Rolle </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Validated </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Enabled </div>
                    </div>
                    <div class="table-cell">
                        <div class="table-header"> Passwort zurücksetzen </div>
                    </div>

                </div>

                <div class="table-row">
            <div class="table-cell">
                <div> <?= $login->__get('user')->id ?> </div>
                <input type="hidden" id="user" name="user" value="<?= $login->__get('user')->id ?>" >
            </div>
            <div class="table-cell">
                <div> <?= $login->__get('user')->firstName ?>  </div>
            </div>
            <div class="table-cell">
                <div> <?= $login->__get('user')->lastName ?>  </div>
            </div>
            <div class="table-cell">
                <div>
                    <select name="role">
                        <option value="admin"
                            <?= ($login->__get('user')->role === 'admin') ? 'selected' : '' ?>
                        >Admin</option>
                        <option value="user"
                            <?= ($login->__get('user')->role === 'user') ? 'selected' : '' ?>
                        >Nutzer</option>
                    </select>
                </div>
            </div>
            <div class="table-cell">
                <select name="validated">
                        <option value="1"
                            <?= ($login->validated) ? 'selected' : '' ?>
                        >validated</option>
                        <option value="0"
                            <?= ($login->validated) ? '' : 'selected' ?>
                        >unvalidated</option>
                </select>

            </div>
            <div class="table-cell">
                <select name="enabled">
                    <option value="1"
                        <?= ($login->enabled) ? 'selected' : '' ?>
                    >enabled</option>
                    <option value="0"
                        <?= ($login->enabled) ? '' : 'selected' ?>
                    >disabled</option>
                </select>
            </div>
            <div class="table-cell">
                <div> <input type="checkbox" id="passwordReset" name="passwordReset" > </div>
            </div>
            <div class="table-cell">
                <button class="buttonForAll" type="submit" name="saveChanges">Änderung Speichern</button>
            </div>
        </div>
            </div>
        </form>
        <?php endforeach ?>

        <? include (VIEWSPATH . 'viewAssets' . DIRECTORY_SEPARATOR . 'upButton.php') ?>

