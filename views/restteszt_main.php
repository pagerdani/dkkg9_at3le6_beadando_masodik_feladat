<h2>Város kiválasztása</h2>

<form action="<?php echo SITE_ROOT . 'restteszt'; ?>" method="POST">
    <div class="form-field">
        <label for="varosid">Város kiválasztása</label>
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

<?php if (isset($viewData['varosid']) && isset($viewData['lelekszamok'])): ?>
<table>
    <thead>
    <tr>
        <th>Év</th>
        <th>Nő</th>
        <th>Féfi</th>
        <th>Összesen</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($viewData['lelekszamok'] as $lelekszam): ?>
        <tr>
            <td><?php echo $lelekszam['ev']; ?></td>
            <td><?php echo $lelekszam['no']; ?></td>
            <td><?php echo $lelekszam['ferfi']; ?></td>
            <td><?php echo $lelekszam['osszesen']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

<?php if (isset($viewData['varosid']) && isset($viewData['lelekszamok'])): ?>
<h2>POST</h2>
<form action="<?php echo SITE_ROOT . 'restteszt'; ?>" method="POST">
    <input type="hidden" name="mode" value="POST">
    <input type="hidden" name="varosid" value="<?php echo $viewData['varosid']; ?>">
    <div class="form-field">
        <label for="ev">Év</label>
        <input id="ev" name="ev" type="number" value="<?php echo ($_POST['ev'] ?? date('Y')); ?>" required>
    </div>

    <div class="form-field">
        <label for="no">Nő</label>
        <input id="no" name="no" type="number" value="<?php echo ($_POST['no'] ?? 0); ?>" required>
    </div>

    <div class="form-field">
        <label for="osszesen">Összesen</label>
        <input id="osszesen" name="osszesen" type="number" value="<?php echo ($_POST['osszesen'] ?? 0); ?>" required>
    </div>

    <div class="form-field">
        <button type="submit">Küldés</button>
    </div>

    <?php if (isset($_POST['mode']) && $_POST['mode'] == 'POST'): ?>
        <div>
            <h3>Státusz: HTTP<?php echo $viewData['httpcode'] ?></h3>
            <p>Válasz:</p>
            <div>
                <pre>
                    <?php print_r($viewData['answer']); ?>
                </pre>
            </div>
        </div>
    <?php endif; ?>
</form>
<?php endif; ?>

<?php if (isset($viewData['varosid']) && isset($viewData['lelekszamok'])): ?>
    <h2>PUT</h2>
    <form action="<?php echo SITE_ROOT . 'restteszt'; ?>" method="POST">
        <input type="hidden" name="mode" value="PUT">
        <input type="hidden" name="varosid" value="<?php echo $viewData['varosid']; ?>">
        <div class="form-field">
            <label for="ev">Év</label>
            <input id="ev" name="ev" type="number" value="<?php echo ($_POST['ev'] ?? date('Y')); ?>" required>
        </div>

        <div class="form-field">
            <label for="no">Nő</label>
            <input id="no" name="no" type="number" value="<?php echo ($_POST['no'] ?? 0); ?>" required>
        </div>

        <div class="form-field">
            <label for="osszesen">Összesen</label>
            <input id="osszesen" name="osszesen" type="number" value="<?php echo ($_POST['osszesen'] ?? 0); ?>" required>
        </div>

        <div class="form-field">
            <button type="submit">Küldés</button>
        </div>

        <?php if (isset($_POST['mode']) && $_POST['mode'] == 'PUT'): ?>
            <div>
                <h3>Státusz: HTTP<?php echo $viewData['httpcode'] ?></h3>
                <p>Válasz:</p>
                <div>
                <pre>
                    <?php print_r($viewData['answer']); ?>
                </pre>
                </div>
            </div>
        <?php endif; ?>
    </form>
<?php endif; ?>

<?php if (isset($viewData['varosid']) && isset($viewData['lelekszamok'])): ?>
    <h2>DELETE</h2>
    <form action="<?php echo SITE_ROOT . 'restteszt'; ?>" method="POST">
        <input type="hidden" name="mode" value="DELETE">
        <input type="hidden" name="varosid" value="<?php echo $viewData['varosid']; ?>">
        <div class="form-field">
            <label for="ev">Év</label>
            <input id="ev" name="ev" type="number" value="<?php echo ($_POST['ev'] ?? date('Y')); ?>" required>
        </div>

        <div class="form-field">
            <button type="submit">Küldés</button>
        </div>

        <?php if (isset($_POST['mode']) && $_POST['mode'] == 'DELETE'): ?>
            <div>
                <h3>Státusz: HTTP<?php echo $viewData['httpcode'] ?></h3>
                <p>Válasz:</p>
                <div>
                <pre>
                    <?php print_r($viewData['answer']); ?>
                </pre>
                </div>
            </div>
        <?php endif; ?>
    </form>
<?php endif; ?>
