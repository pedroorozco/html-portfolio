/* 
Name:           Pedro Orozco
Date:		    02/16/2024
Description:	  This JS file contains code for dropdown when
                  navbar becomes mobile screen size and for dark
                  mode button
*/

// When user clicks on button, toggle between dark / light mode
function darkMode() {
    // Toggling on body
    document.body.classList.toggle("dark-mode");

    // Toggling on other elements
    var container = document.querySelector(".container");
    container.classList.toggle("dark-mode");

    var navbar = document.querySelector(".navbar");
    navbar.classList.toggle("dark-mode");

    var collapser = document.querySelector(".collapse");
    collapser.classList.toggle("dark-mode");

    var mainContainer = document.querySelector(".container-main");
    mainContainer.classList.toggle("dark-mode");

    var leftGrid = document.querySelector(".grid-left");
    leftGrid.classList.toggle("dark-mode");

    var mainContainer = document.querySelector(".container-main");
    mainContainer.classList.toggle("dark-mode");

    var footer = document.querySelector(".footer");
    footer.classList.toggle("dark-mode");
}


