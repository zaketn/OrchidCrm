<div class="modal fade text-black" id="myProjectsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Проекты, заказанные компанией</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($user->projects()->exists())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Название</th>
                            <th scope="col">Репозиторий</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Договор</th>
                            <th scope="col">Начало выполнения</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->projects as $project)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $project->name }}</td>
                                <td>
                                    <a href="{{ $project->repo_link }}">Ссылка</a>
                                </td>
                                <td>
                                    {!! $project->presenter()->localizedStatus() !!}
                                </td>
                                <td>
                                    <a href="#">Ссылка</a>
                                </td>
                                <td>{{ datetime_format($project->created_at) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center text-secondary">Проектов пока нет.</h3>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
