function ajaxPost(url, formData) {
    // $("body").LoadingOverlay("show");
    return $.ajax({
        url: url,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        type: "POST",
        dataType: 'json',
        processData: false,
        contentType: false,
        // success: function (response) {
        //     $("body").LoadingOverlay("hide", true);

        //     if (response.meta.status == 'error') {
        //         toastr.error(response.meta.message);
        //         return false;
        //     } else {
        //         toastr.success(response.meta.message);
        //         dataTable.ajax.reload(null, false);
        //         $('#createProduct').modal('hide');
        //         $('#form').trigger('reset');
        //     }
        // },
        // error: function (jqXhr, textStatus, errorThrown) {
        //     $("#createProduct").LoadingOverlay("hide", true);
        //     toastr.error(errorThrown);
        // }
    });
}

