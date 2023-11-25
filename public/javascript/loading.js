function showLoading() {
  $(".loading-overlay").css("display", "flex");
}

// Hide loading overlay
function hideLoading() {
  $(".loading-overlay").css("display", "none");
}

// Example: Call showLoading before making an AJAX request and hideLoading after receiving the response
$(document).ajaxStart(function () {
  showLoading();
});

$(document).ajaxStop(function () {
  hideLoading();
});