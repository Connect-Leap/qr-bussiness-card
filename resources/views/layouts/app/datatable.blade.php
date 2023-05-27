<script>
    $('.datatable-jquery').DataTable({
        language: {
            paginate: {
                next: '&#8594;', // or '→'
                previous: '&#8592;' // or '←' 
            }
        }
    });

    $('select[name="DataTables_Table_0_length"]').css('padding-right', '30px')

    $('#DataTables_Table_0_info').parent().css('margin-bottom', '20px')
</script>
