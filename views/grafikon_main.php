<h1>Lélekszám grafikon</h1>
<form action="<?php echo SITE_ROOT . 'grafikon'; ?>" method="POST">
    <div class="form-field">
        <label for="varosid">Város</label>
        <select name="varosid" id="varosid">
            <?php foreach($viewData['varosok'] as $varos): ?>
                <option value="<?php echo $varos['id']; ?>" <?php echo (isset($viewData['varosid']) && $viewData['varosid'] == $varos['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($varos['nev']); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-field">
        <button type="submit">Küldés</button>
    </div>
</form>

<?php if (isset($viewData['result'])): ?>
<canvas id="year_chart"></canvas>
<script>
    var chartData = <?php echo json_encode($viewData['result']); ?>;
</script>
<?php endif; ?>
