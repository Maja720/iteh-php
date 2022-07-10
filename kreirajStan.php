<?php
include 'header.php';
?>

<div class='container mt-2 mb-5'>
    <h1 class='text-center text-dark'>
        Kreiraj novi stanovi
    </h1>
    <div class='row mt-2 d-flex justify-content-center'>
        <div class='col-7'>
            <form id='forma'>

                <div class='form-group'>
                    <label for="cena">Cena</label>
                    <input required name="cena" class="form-control" type="number" min="1" id="cena">
                </div>

                <div class='form-group'>
                    <label for="kvadratura">Kvadratura</label>
                    <input required name="kvadratura" class="form-control" type="number" min="1" id="kvadratura">
                </div>
                <div class='form-group'>
                    <label for="boja">Ulica</label>
                    <select required name='ulica' class="form-control" id="ulica"></select>
                </div>
                <div class='form-group'>
                    <label for="broj">Broj</label>
                    <input required name="broj" class="form-control" type="number" min="1" id="broj">
                </div>
                <div class='form-group'>
                    <label for="sprat">Sprat</label>
                    <input required name="sprat" class="form-control" type="number" min="1" id="sprat">
                </div>
                <div class='form-group'>
                    <label for="kategorija">Kategorija</label>
                    <select required name="kategorija" class="form-control" id="kategorija"></select>
                </div>
                <div class='form-group'>
                    <label for="slika">Slika</label>
                    <input required name="slika" class="form-control-file" type="file" min="1" id="slika">
                </div>

                <button type="submit" class="btn btn-primary form-control">Kreiraj</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function() {
        ucitajOptions('server/ulica/read.php', 'ulica');
        ucitajOptions('server/kategorija/read.php', 'kategorija');
        $('#forma').submit(e => {

            e.preventDefault();

            const sprat = $('#sprat').val();
            const cena = $('#cena').val();
            const ulica = $('#ulica').val();
            const broj = $('#broj').val();
            const kategorija = $('#kategorija').val();
            const kvadratura = $('#kvadratura').val();
            const slika = $("#slika")[0].files[0];
            const fd = new FormData();
            fd.append("slika", slika);
            fd.append("sprat", sprat);
            fd.append("kvadratura", kvadratura);
            fd.append("broj", broj);
            fd.append("cena", cena);
            fd.append("ulica", ulica);
            fd.append("kategorija", kategorija);

            $.ajax({
                url: "./server/stan/create.php",
                type: 'post',
                data: fd,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data != '200') {
                        alert(data);
                    }

                },

            })
        })
    })

    function ucitajOptions(url, htmlElement) {
        $.getJSON(url).then(res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            for (let element of res.kolekcija) {
                $('#' + htmlElement).append(`
                    <option value="${element.id}">
                        ${element.naziv}
                        </option>
                `)
            }
        })
    }
</script>

<?php
include 'footer.php';
?>