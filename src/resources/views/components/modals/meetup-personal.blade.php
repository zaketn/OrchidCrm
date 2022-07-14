<div class="modal fade text-black" id="myMeetupsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Мои заявки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($user->meetups()->exists())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">На основе заявки</th>
                            <th scope="col">Адрес</th>
                            <th scope="col">Место</th>
                            <th scope="col">Дата и время</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->meetups as $meetup)
                            <tr>
                                <td>{{ $meetup->lead->header }}</td>
                                <td>{{ $meetup->address }}</td>
                                <td>
                                    {{ $meetup->place }}
                                </td>
                                <td>{{ $meetup->presenter()->localizedDate() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center text-secondary">Запланированных встреч пока нет.</h3>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
