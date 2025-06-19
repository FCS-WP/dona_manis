$(function () {
  // $(document).on('click', '.lightbox-zippy-btn', function(e){
  //     e.preventDefault()
  //     const product_id = $(this).data('product_id');
  //     $('#lightbox-zippy-form').attr('data-product_id', product_id);
  // })
  $(document).on("click", ".btn-close-lightbox", function () {
    // console.log('first')
    $(".dialog-close-button").trigger("click");
  });

  $('input[name="quantity"').on("change", function () {
    $(".add_to_cart_button").attr("quantity", $(this).val());
    console.log($(this).val());
  });
});

("use strict");
$ = jQuery;

$(document).ready(function () {
  $(document).on("click", "#removeMethodShipping", function () {
    Swal.fire({
      title: "Are you sure to changes?",
      text: "Your current cart will be cleared",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes!",
      cancelButtonText: "Cancel",
      customClass: {
        popup: "confirmRemovePopup",
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/wp-admin/admin-ajax.php",
          type: "POST",
          data: {
            action: "remove_cart_session",
          },
          success: function (response) {
            Swal.fire({
              title: "Deleted!",
              text: "Your cart has been cleared.",
              icon: "success",
              customClass: {
                popup: "popupAlertDeleteSuccess",
              },
            }).then(() => {
              $(document.body).trigger("updated_wc_div");

              location.reload();
            });
          },
          error: function () {
            Swal.fire("Error!", "Something went wrong.", "error");
          },
        });
      }
    });
  });
});
