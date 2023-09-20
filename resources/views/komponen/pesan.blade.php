<!-- ... Your page content ... -->
@if (Session::has('success_add'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="successAddToast" class="toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-white">Success</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
            Data berhasil ditambahkan
        </div>
    </div>
</div>
<script>
    var successAddToast = new bootstrap.Toast(document.getElementById('successAddToast'));
    successAddToast.show();
</script>
@endif

@if (Session::has('success_update'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="successUpdateToast" class="toast bg-info" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-white">Info</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
            Data berhasil diubah
        </div>
    </div>
</div>
<script>
    var successUpdateToast = new bootstrap.Toast(document.getElementById('successUpdateToast'));
    successUpdateToast.show();
</script>
@endif

@if (Session::has('success_delete'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="successDeleteToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-white">Info</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
            Data berhasil dihapus.
        </div>
    </div>
</div>
<script>
    var successDeleteToast = new bootstrap.Toast(document.getElementById('successDeleteToast'));
    successDeleteToast.show();
</script>
@endif


@if (Session::has('error'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050">
    <div id="errorToast" class="toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto text-white">Error</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body text-white">
            Maaf ada kesalahan
            @foreach ($errors->all() as $error)
                <div class="text-danger">{{ $error }}</div>
            @endforeach
        </div>
    </div>
</div>
<script>
    var errorToast = new bootstrap.Toast(document.getElementById('errorToast'));
    errorToast.show();
</script>
@endif

</body>
</html>
