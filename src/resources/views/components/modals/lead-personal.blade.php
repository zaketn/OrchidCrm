<div class="modal fade text-black" id="myLeadsModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Мои заявки</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($user->leads()->exists())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Желаемая дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->leads as $lead)
                            <tr>
                                <td>{{ $lead->header }}</td>
                                <td>
                                    {!! $lead->presenter()->localizedStatus() !!}
                                </td>
                                <td>{{ datetime_format($lead->desired_date) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center text-secondary">Поданых заявок пока нет.</h3>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
