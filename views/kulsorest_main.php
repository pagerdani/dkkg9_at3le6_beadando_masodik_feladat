<h1>Külső REST API</h1>

<form action="<?php echo SITE_ROOT . 'kulsorest' ?>" method="POST">
    <div class="form-field">
        <label for="datum">Dátum</label>
        <input required type="text" id="datum" name="datum" data-max="<?php echo date('Y-m-d'); ?>" data-value="<?php echo $viewData['datum']; ?>">
    </div>
    <div class="form-field">
        <button type="submit">Küldés</button>
    </div>
</form>

<?php if (isset($viewData['result'])): ?>
<pre>
    <?php print_r($viewData['result']); ?>
</pre>
<?php endif; ?>
