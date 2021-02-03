window.onload = _loadRandomBackground;
function _loadRandomBackground(){
var ImageID = Math.floor((Math.random() * 7));
var Images = ["Volcano.png","Arabia.png","Artemis.png","Morocco.png","Lilypad.png","Polder.png","Treeline.png","Tulips.png"];
document.getElementById("LogoDiv").style.backgroundImage ="linear-gradient(to left, rgba(226, 225, 225, 0.2), rgba(226, 225, 225, 1)),url('Backgroundimages/" + Images[ImageID] + "')";
}