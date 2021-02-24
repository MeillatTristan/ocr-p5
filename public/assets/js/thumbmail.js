function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $("#containerPreview").css("background-image", "url("+e.target.result +")");
          $("#containerPreview").hide();
          $("#containerPreview").fadeIn(650);
      };
      reader.readAsDataURL(input.files[0]);
  }
}
$("#uploadThumbmail").change(function() {
  readURL(this);
});