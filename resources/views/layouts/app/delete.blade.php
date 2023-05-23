<script>
    $(document).ready(function() {
        $('.btn-delete').click(function(e) {
            e.preventDefault()
            let href = $(this).attr('href')

            swal({
                title: "Warning",
                text: "This Data Will be Deleted",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((result) => {
                if (result) {
                    $(this).parent('div').parent('div').parent('td').parent('tr').remove()
                    $.ajax({
                        url: href,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(res) {
                            swal({
                                title: 'Success',
                                text: 'Data Successfully Deleted',
                                icon: "success",
                                button: "Close"
                            }).then(() => {
                                location.reload()
                            })
                        },
                        error: function(res) {
                            swal({
                                title: "Oops..!",
                                text: "Something went Wrong",
                                icon: "error",
                                button: "Close",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    })
                }
            })
        })
    })
</script>
