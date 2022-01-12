<section class='shadow-2-strong m-3'>
    <form method='post' class='d-flex px-2  gap-3 flex-column'>
        <div class='row'>
            <h2>Wsparcie</h2>
            <h5>Przydzielenie zgłoszenia do odpowiedniego tematu, przyśpieszy odpowiedź</h5>
        </div>


        <div class='row justify-content-between'>
            <div class='col-7'>
                <div class=' form-outline my-3'>
                    <input class="form-control" type="text" name="comment"></input>
                    <label class="form-label" style="margin-left: 0px;">Nagłówek zgłoszenia</label>
                </div>
                <div class=' form-outline justify-content-around'>
                    <textarea class="form-control" type="text" name="comment" rows="9"></textarea>
                    <label class="form-label" style="margin-left: 0px;">Opis zgłoszenia</label>
                </div>

            </div>

            <div class='col-5'>
                <div class=' form-outline my-3'>
                    <input class="form-control" type="text" name="comment" value='<?=$user['user_email']?>'></input>
                    <label class="form-label" style="margin-left: 0px;">Adres kontaktowy</label>
                </div>
                <div class='my-3'>
                    <label class='form-label'>Temat kontaktu</label>
                    <select placeholder='testowe' class="form-control">
                        <option value="tech">Błąd techniczny (błąd przy korzystaniu)</option>
                        <option value="visual">Błąd wizualny (coś źle się wyświetla)</option>
                        <option value="logic">Błąd logiczny (źle policzone wartości)</option>
                        <option value="new">Dodanie funkcjonalności / integracji</option>
                    </select>
                </div>
                <div class=''>
                    <label for="formFileMultiple" class="form-label">Dodatkowe screenshoty (.png, .jpg)</label>
                    <input class="form-control" type="file" id="formFileMultiple" multiple />
                </div>
                <div class='row mt-4'>
                    <button class='btn btn-success btn-lg'>Wyślij</button>
                </div>
            </div>

        </div>

    </form>

</section>

<section class='shadow-2-strong m-3'>
    <div class='d-flex flex-column gap-4'>

    <div class='row w-50'>
        <h2>Twoje zgłoszenia</h2>
        <h5>Szczegóły twoich zgłoszeń</h5>
    </div>
    <div class='row'>
        <table class='table table-bordered table-sm '>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Tytuł</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>AS5503</td>
                    <td>Bla bla asd</td>
                    <td>W toku</td>
                </tr>
                <tr>
                    <td>ALS401</td>
                    <td>Inny opis</td>
                    <td>Nowy</td>
                </tr>
                <tr>
                    <td>POI394</td>
                    <td>Jeszcze coś innego, bradzo dlugiego</td>
                    <td>Nowy</td>
                </tr>
                <tr>
                    <td>MUN392</td>
                    <td>Nie da się wcisnąć</td>
                    <td>Zamknięty</td>
                </tr>

            </tbody>
        </table>
    </div>


    </div>
  

    </div>
</section>