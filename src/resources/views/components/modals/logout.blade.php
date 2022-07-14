<div class="modal fade text-black" id="logoutModal" tabindex="-1">
    <form class="modal-dialog modal-sm text-left" action="{{ route('logout') }}" method="post">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Выход</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Вы действительно хотите выйти?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Вернуться назад</button>
                <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Да, выйти</button>
            </div>
        </div>
    </form>
</div>
