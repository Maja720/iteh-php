<?php
    include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Ulice
    </h1>
</div>

<div class='container'>
    <div class='row mt-2'>
        <div class='col-7'>
            <table class='table table-dark'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Izmeni</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='ulice'>

                </tbody>
            </table>


        </div>
        <div class='col-5'>
            <h3 class="text-dark text-centar" id='naslov'>Kreiraj kategoriju</h3>
            <form id='forma'>
                <div class='form-group'>
                    <label for="naziv">Naziv</label>
                    <input required class="form-control" type="text" id="naziv">
                </div>
                <button class="btn btn-dark form-control" type="submit">Sacuvaj</button>

            </form>
            <button id="vrati" hidden class="btn btn-secondary form-control mt-2" onclick="setIndex(-1)">Vrati se
            </button>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let ulice = [];
    let selIndex = -1;



    $(function () {
        ucitajUlice();
        $('#forma').submit(e => {
            e.preventDefault();
            const naziv = $('#naziv').val();
            if (selIndex === -1) {
                $.post('server/ulica/create.php', { naziv }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        ucitajUlice();
                    }
                })
            } else {
                $.post('server/ulica/update.php', { naziv, id: ulice[selIndex].id }).then(res => {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error);
                    } else {
                        setulice(ulice.map((element, index) => {
                            if (index !== selIndex) {
                                return element;
                            }
                            return { id: element.id, naziv };
                        }));
                        setIndex(-1);
                    }
                })
            }
        })
    })

    function ucitajUlice() {
        $.getJSON('server/ulica/read.php').then(res => {
            console.log(res);
            if (!res.status) {
                alert(res.error);
                return;
            }
            setulice(res.kolekcija);
        })
    }
    function obrisi(id) {
        $.post('server/ulica/delete.php', { id }).then((res) => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }
            setulice(ulice.filter((e) => e.id != id));

            setIndex(-1);
        })
    }
    function setulice(val) {
        ulice = val;
        $('#ulice').html('');

        let index = 0;
        for (let ulica of ulice) {
            $('#ulice').append(`
                    <tr>
                        <td>${ulica.id}</td>
                        <td>${ulica.naziv}</td>
                        <td>
                            <button class='btn btn-light form-control' onClick="setIndex(${index})" >Izmeni</button>
                        </td>
                        <td>
                            <button class='btn btn-danger form-control' onClick="obrisi(${ulica.id})">Obrisi</button>
                        </td>
                    </tr>
                `);
            index++;
        }
    }
    function setIndex(val) {
        selIndex = val
        if (selIndex === -1) {
            $('#naslov').html('Kreiraj kategoriju');
            $('#naziv').val('');

        } else {
            $('#naslov').html('Izmeni kategoriju')
            $('#naziv').val(ulice[selIndex].naziv);
        }
        $('#vrati').attr('hidden', selIndex === -1)
    }

</script>
<?php
    include 'footer.php';
?>