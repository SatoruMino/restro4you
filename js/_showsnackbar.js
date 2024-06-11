function showSnackBar(id, message) {
  var snackbar = id;
  snackbar.text(message);
  snackbar.addClass("show");
  setTimeout(function () {
    snackbar.removeClass("show");
  }, 3000);
}
