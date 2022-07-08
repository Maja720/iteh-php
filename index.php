<?php
    include 'header.php';
?>

<div class='container mt-2'>
    <h1 class='text-center text-dark'>
        Stanovi u Beogradu
    </h1>
    <div class="row mt-2">
        <div class="col-3">
            <select onchange="render()" class="form-control" id="sort">
                <option value="1">Po ceni rastuce</option>
                <option value="-1">Po ceni opadajuce</option>
            </select>
        </div>
        <div class="col-6">
            <select onchange="render()" class="form-control" id="ulice">
                <option value="0">Sve ulice</option>
            </select>
        </div>
        <div class="col-3">
            <select onchange="render()" class="form-control" id="kategorije_search">
                <option value="0">Sve kategorije</option>
            </select>
        </div>

    </div>
    <div id='podaci'>

    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    let stanovi = [];
    let ulice = [];
    let kategorije = [];
    $(function () {
        $.getJSON('server/ulica/read.php').then((res => {
            if (!res.status) {
                alert(res.error);
                return;
            }
            console.log('set ulice')
            ulice = res.kolekcija;
            for (let ulica of ulice) {
                $('#ulice').append(`
                <option value="${ulica.id}"> ${ulica.naziv}</option>
                `)
            }
        }))
            .then(() => {
                return $.getJSON('server/kategorija/read.php')

            })
            .then((res => {
                if (!res.status) {
                    alert(res.error);
                    return;
                }
                console.log('set kategorije')
                kategorije = res.kolekcija;
                for (let kategorija of kategorije) {
                    $('#kategorije_search').append(`
                <option value="${kategorija.id}"> ${kategorija.naziv}</option>
                `)
                }
            }))
            .then(ucitajStanove)


    })



    function ucitajStanove() {
        $.getJSON('server/stan/read.php', (res => {
            if (!res.status) {
                alert(res.error);
                return;
            }

            stanovi = res.kolekcija || [];
            render();
        }))
    }
    function render() {

        const sort = Number($('#sort').val());
        const ul = Number($('#ulice').val());
        const kat = Number($('#kategorije_search').val());
        const niz = stanovi.filter(element => {
            return (ul == 0 || element.ulica == ul) && (kat == 0 || element.kategorija == kat)
        }).sort((a, b) => {
            return sort * (a.cena - b.cena)
        });
        let red = 0;
        let kolona = 0;
        $('#podaci').html(`<div id='row-${red}' class='row mt-2 red'></div>`)
        for (let stan of niz) {
            if (kolona === 4) {
                kolona = 0;
                red++;
                $('#podaci').append(`<div id='row-${red}' class='row mt-2 red'></div>`)
            }
            $(`#row-${red}`).append(
                `
                        <div class='col-3 pt-2 bg-white card'>
                            <div class="card" >
                                <img class="card-img-top" src="${stan.slika}" alt="Card image cap">
                                <div class="card-body">
                                  
                                    <h6 class="card-title">Cena: ${stan.cena}</h6>
                                    <h6 class="card-title">Povrsina: ${stan.kvadratura}</h6>
                                    <h6 class="card-title">Kategorija: ${kategorije.find(element => element.id === stan.kategorija).naziv}</h6>
                                    <h6 class="card-title">Ulica: ${ulice.find(element => element.id === stan.ulica).naziv} ${stan.broj}</h6>
                                    <h6 class="card-title">Sprat: ${stan.sprat}</h6>
                                  
                                </div>
                                <div class="card-footer ">
                                    <button class='btn btn-danger form-control' onClick="obrisi(${stan.id})">Obrisi</button>
                                </div>
                            </div>
                        </div>
                    `
            )
        }

    }
    function obrisi(id) {
        id = Number(id);
        $.post('server/stan/delete.php', { id }).then(res => {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
                return;
            }

            stanovi = stanovi.filter(element => element.id != id);
            render();
        })
    }
</script>

<?php
    include 'footer.php';
?>