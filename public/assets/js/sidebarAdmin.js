function sidebarShow(){
  var sidebar = document.getElementById("sidebar");
  var containerGlobal = document.getElementById('containerGlobal');
  if (sidebar.style.transform === "translateX(0px)") {
    sidebar.style.transform = "translateX(-280px)";
    containerGlobal.style.transform = "translateX(0px)";
  }
  else{
    sidebar.style.transform = "translateX(0px)";
    containerGlobal.style.transform = "translateX(280px)";
  }

}