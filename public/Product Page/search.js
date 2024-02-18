/* 
Name:           Pedro Orozco
Date:		    02/16/2024
Description:	  This JS file contains code for dropdown when
                  navbar becomes mobile screen size
*/

// When user clicks on button, toggle between hiding / showing dropdown content
function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close dropdown if user clicks outside of it
window.onclick = function(e) {
    if (!e.target.matches('.dropbtn')) {
        var myDropdown = document.getElementById("myDropdown");
        if (myDropdown.classList.contains('show')) {
            myDropdown.classList.remove('show');
        }
    }
}