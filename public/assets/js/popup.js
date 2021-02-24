function popup(id){
  var popup = document.getElementById("popup-" + id);
  if (popup.style.display === "flex") {
    popup.style.display = "none";
  }
  else{
    popup.style.display = "flex";
  }

}