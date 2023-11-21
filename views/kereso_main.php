<h1>Város lélekszám kereső</h1>
<div id = "informaciosdiv">
    <table id = "varosinfo">
        <thead>
            <tr>
                <th>Összesen</th>
                <th>Férfi</th>
                <th>Nő</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <span id="osszesen" class="adat"></span><br>
                </td>
                <td>
                    <span id="no" class="adat"></span><br>
                </td>
                <td>
                    <span id="ferfi" class="adat"></span><br>
                </td>
            </tr>
        </tbody>
    </table>

    <div>
        <div class="form-field">
            <label for="megyeselect">Megye:</label>
            <select id="megyeselect"></select>
        </div>
        <div class="form-field">
            <label for ="varosselect">Város:</label>
            <select id ="varosselect"></select>
        </div>
        <div class="form-field">
            <label for ="evselect">Év:</label>
            <select id="evselect"></select>
        </div>
    </div>

    <button data-url="<?php echo SITE_ROOT . 'pdfexport'; ?>" id="export-button" disabled>PDF Export</button>
</div>