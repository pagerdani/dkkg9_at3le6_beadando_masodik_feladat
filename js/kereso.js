class OptionRenderer {
    constructor(selector, type = 'normal') {
        this.selector = selector;
        this.type = type;
        this.lista = null;
    }

    setLista(lista) {
        this.lista = lista;
    }

    render() {
        $("<option>").val("0").text("Válasszon ...").appendTo(this.selector);

        for(let i=0; i < this.lista.length; i++) {
            const item = this.lista[i];

            if (this.type == 'ev') {
                $("<option>").val(item.ev).text(item.ev).appendTo(this.selector);
            } else {
                $("<option>").val(item.id).text(item.nev).appendTo(this.selector);
            }
        }
    }
}

let megyeRenderer = new OptionRenderer("#megyeselect");
let varosRenderer = new OptionRenderer("#varosselect");
let evRenderer = new OptionRenderer("#evselect", "ev")

function megyek() {
    $.post(
        window.location.href,
        {"op" : "megye"},
        function(data) {
            megyeRenderer.setLista(data.lista);
            megyeRenderer.render();
        },
        "json"
    );
}

function varosok() {
    $("#varosselect").html("");
    $("#evselect").html("");
    $(".adat").html("");
    $('#export-button').attr('disabled', true);
    const megyeid = $("#megyeselect").val();
    if (megyeid != 0) {
        $.post(
            window.location.href,
            {"op" : "varos", "id" : megyeid},
            function(data) {
                varosRenderer.setLista(data.lista);
                varosRenderer.render();
            },
            "json"
        );
    }
}

function ev() {
    $("#evselect").html("");
    $(".adat").html("");
    $('#export-button').attr('disabled', true);
    const varosid = $("#varosselect").val();
    if (varosid != 0) {
        $.post(
            window.location.href,
            {"op" : "ev", "id" : varosid},
            function(data) {
                evRenderer.setLista(data.lista);
                evRenderer.render();
            },
            "json"
        );
    }
}

function lekekszam() {
    $(".adat").html("");
    const ev = $("#evselect").val();
    if (ev != 0) {
        $('#export-button').attr('disabled', false);

        $.post(
            window.location.href,
            {"op" : "info", "ev" : ev, "varosid": $("#varosselect").val() },
            function(data) {
                $("#osszesen").text(data.osszesen);
                $("#no").text(data.no);
                $("#ferfi").text(data.ferfi);
            },
            "json"
        );
    }
}

function exportpdf() {
    const url = $(this).attr('data-url');
    const varosId = $("#varosselect").val();
    const ev = $("#evselect").val();

    window.location.href = url + '/' + varosId.toString() + '/' + ev.toString();
}

$(document).ready(function () {
    megyek();

    $("#megyeselect").change(varosok);
    $("#varosselect").change(ev);
    $("#evselect").change(lekekszam);

    $('#export-button').click(exportpdf);
});