<!-- ... Your page content ... -->
{{-- toast list : success , info , warning , error  --}}
@if (Session::has('success_add'))
    <script>
        toastr.success("{!! Session::get('success_add') !!}")
    </script>
@endif

@if (Session::has('success_update'))
<script>
    toastr.info("{!! Session::get('success_update') !!}")
</script>
@endif

@if (Session::has('success_delete'))
<script>
    toastr.warning("{!! Session::get('success_delete') !!}")
</script>
@endif

@if (Session::has('error'))
<script>
    toastr.error("{!! Session::get('error') !!}")
</script>
@endif



</body>
</html>
