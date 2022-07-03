<div class="modal fade text-dark" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">

        <form class="modal-content" action="{{ route('leads.create') }}" method="post">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Отправьте заявку на встречу</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Заголовок</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"
                           placeholder="Релизация моей идеи" name="header" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                              name="description" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="date_time">Дата</label><br>
                    <input type="date" name="date" id="date" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="time">Время</label>
                    <select class="form-select" name="time" id="time" required>
                        <option value="10:00">10:00</option>
                        <option value="12:00">12:00</option>
                        <option value="14:00">14:00</option>
                        <option value="16:00">16:00</option>
                        <option value="18:00">18:00</option>
                    </select>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </div>
        </form>

    </div>
</div>
