<noscript>
    <input class="messageToggle" type="checkbox" id="infoToggle">
    <div class="message warningMessage">
        <label class="messageClose" for="infoToggle">&times</label>
        <p>Bitte beachten Sie, dass sie Javascript aktivieren müssen, um von allen komfortfunktionen dieser Seite profitieren zu können!</p>
    </div>
</noscript>

<div class="formWrapper">
    <h1>Wie viele Punkte schaffen Sie?</h1>
    <h2>Steuerung mit W,A,S,D</h2>
    <canvas id="snakeCan" width="400" height="600"></canvas>
    <script src="<?= JAVASCRIPTPATH . 'accounts' . DIRECTORY_SEPARATOR . 'whileYouWait.js' ?>"></script>
</div>