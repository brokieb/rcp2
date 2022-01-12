
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-xl-5 col-md-8'>

                <form method='post' class='rounded shadow-5-strong p-5'>
                    <div class='row mb-4'>
                        <h2>Wyślij informacje o nieobecności</h2>
                    </div>
                    <div class="row mb-4" data-mdb-inline="true">
                        <label for='from' class="col-1 form-label">Od</label>
                        <div class='col-11'>
                            <input type='date' name='from' class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4" data-mdb-inline="true">
                        <label for='to' class="col-1 form-label control-label">Do</label>
                        <div class='col-11'>
                            <input type='date' name='to' class="form-control">
                        </div>
                    </div>
                    <div class="row mb-4" data-mdb-inline="true">
                        <label class='col-1 form-label'>Typ</label>
                        <div class='col-11'>
                            <select placeholder='testowe' class="form-control">
                                <option value="" disabled selected>Typ nieobecności</option>
                                <option value="urlop">Urlop</option>
                                <option value="inne">Inna nieobecność</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-outline">
                        <textarea class="form-control" type='text' name='comment'></textarea>
                        <label class="form-label">Komentarz</label>
                    </div>
                    
                    
                    <input type='hidden' name='mode' value='9'>
                    <div class='row mt-4'>
                        <button class='btn btn-success btn-lg'>Wyślij</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
