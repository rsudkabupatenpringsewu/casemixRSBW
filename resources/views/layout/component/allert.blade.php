<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
        @if (session('successupload'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('successupload') }}'
            });
        @endif
    });
</script>


