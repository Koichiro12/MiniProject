function confirmDelete(e,val){
    e.preventDefault();
    var form = val.closest("form");
    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda tidak bisa membatalkan proses ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, saya yakin !",
    }).then(function(isConfirm){
        if(isConfirm){
            form.submit();
        }
    });
}

$(function () {
    $(".a-confirm").on("click", function (e) {
        e.preventDefault();
        var link = $(this).attr('href');

        Swal.fire({
          title: "Apakah anda yakin?",
          text: "Anda tidak bisa membatalkan proses ini!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          cancelButtonColor: "#d33",
          confirmButtonText: "Ya, saya yakin !",
      }).then(function(isConfirm){
        if(isConfirm){
            form.submit();
        }
    });
    });
    $(".form-confirm").on("click", function (e) {
        e.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda tidak bisa membatalkan proses ini!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, saya yakin !",
        }).then(function(isConfirm){
            if(isConfirm){
                form.submit();
            }
        });
    });
});
