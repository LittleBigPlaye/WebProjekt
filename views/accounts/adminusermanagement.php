<div class="formWrapper">
    <h1>Benutzerkonten verwalten</h1>

    <div class="table userManagement">
        <div class="tableRow head">
            <!-- <div class="tableCell">LoginID</div> -->
            <div class="tableCell center">Vorname</div>
            <div class="tableCell center">Nachname</div>
            <div class="tableCell center">Rolle</div>
            <div class="tableCell center">Validated</div>
            <div class="tableCell center">Enabled</div>
            <div class="tableCell center">Passwort zurücksetzen</div>
            <div class="tableCell center">Bestätigung</div>
        </div>

        <?php foreach($logins as $index => $login) : ?>
            <form class="tableRow" method="post">

                    <input type="hidden"name="user" value="<?=htmlspecialchars($login->user->id)?>">

                    <div class="tableCell center">
                        <label class="mobileLabel" for="firstName<?=$index?>">Vorname</label>
                        <span id=firstName<?=$index?>><?=htmlspecialchars($login->user->firstName)?></span>
                    </div>
                    
                    <div class="tableCell center">
                        <label class="mobileLabel" for="lastName<?=$index?>">Nachname</label>
                        <span id="lastName<?=$index?>"><?=htmlspecialchars($login->user->lastName)?></span>
                    </div>
                    
                    <div class="tableCell center">
                        <label class="mobileLabel" for="usertype<?=$index?>">Kontotyp</label>
                        <select id="usertype<?=$index?>" name="role">
                            <option value="admin"
                                <?= ($login->user->role === 'admin') ? 'selected' : '' ?>>
                                Admin</option>
                            <option value="user"
                                <?= ($login->user->role === 'user') ? 'selected' : '' ?>>
                                Nutzer</option>
                        </select>
                    </div>

                    <div class="tableCell center">
                        <label class="mobileLabel" for="validated<?=$index?>">Validierung</label>
                        <select id="validadet<?=$index?>" name="validated">
                            <option value="1"
                                <?= ($login->validated) ? 'selected' : '' ?>
                            >validiert</option>
                            <option value="0"
                                <?= ($login->validated) ? '' : 'selected' ?>
                            >nicht validiert</option>
                        </select>
                    </div>

                    <div class="tableCell center">
                        <label class="mobileLabel" for="enabled<?=$index?>">Kontostatus</label>
                        <select id="enabled<?=$index?>" name="enabled">
                            <option value="1"
                                <?= ($login->enabled) ? 'selected' : '' ?>
                            >aktiv</option>
                            <option value="0"
                                <?= ($login->enabled) ? '' : 'selected' ?>
                            >gesperrt</option>
                        </select>
                    </div>

                    <div class="tableCell center">
                        <label class="mobileLabel" for="passwordReset<?=$index?>">Passwort zurücksetzen</label>
                            <input id="passwordReset<?=$index?>" type="checkbox" id="passwordReset" name="passwordReset" >
                        
                    </div>

                    <div class="tableCell center">
                        <input type="submit" class="buttonForAll" name="saveChanges" value="Änderungen speichern">
                    </div>
            </form>
        <?php endforeach ?>
    </div>
</div>


