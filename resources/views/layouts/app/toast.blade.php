@if (Session::has('success'))
<script>
iziToast.success({
    title: 'Success',
    position: 'topRight',
    message: "{{ Session::get('success') }}",
});
</script>
@elseif (Session::has('fail'))
<script>
iziToast.warning({
    title: 'Fail',
    position: 'topRight',
    message: "{{ Session::get('fail') }}",
});
</script>
@elseif (Session::has('error'))
<script>
iziToast.error({
    title: 'Error',
    position: 'topRight',
    message: "{{ Session::get('error') }}",
});
</script>
@endif
