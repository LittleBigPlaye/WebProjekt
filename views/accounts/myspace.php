
<div class="formWrapper">
    <form class="productForm">
        <h1>
            Das ist dein Konto <?=htmlspecialchars($user->firstName)?>
        </h1>

        <section>
            <label>Vorname: <?=htmlspecialchars($user->firstName)?>  </label>
            <label>zweiter Vorname: <?=htmlspecialchars($user->secondName)?></label>
            <label>Nachname: <?=htmlspecialchars($user->lastName)?></label>
            <label>Geburtstag: <?=htmlspecialchars($user->birthDate)?></label>
            <label>Telefonnummer: <?=htmlspecialchars($user->phone)?></label>
            <label>Geschlecht: <?=htmlspecialchars($user->gender)?></label>
            <h2>Adresse</h2>
            <label>Strasse: <?=htmlspecialchars($address->street)?></label>
            <label>Hausnummer: <?=htmlspecialchars($address->streetNumber)?></label>
            <label>Postleitzahl: <?=htmlspecialchars($address->zipCode)?></label>
            <label>Stadt: <?=htmlspecialchars($address->city)?></label>
        </section>
    </form>
</div>
