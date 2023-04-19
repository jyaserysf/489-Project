/* Set the width of the side navigation to 270px and the left margin of the page content to 270px */
function openNav() {
    document.getElementById("mySidenav").classList.add("open");
    document.getElementById("main").style.marginLeft = "270px";
} 

/* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
function closeNav() {
    document.getElementById("mySidenav").classList.remove("open"); 
    document.getElementById("main").style.marginLeft = "0";
}