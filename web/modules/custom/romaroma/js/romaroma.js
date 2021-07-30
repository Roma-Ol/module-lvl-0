"use strict";

// Creating the variables well w3 w/
let animatedDivForm = document.querySelector('.form-wrapper-first'),
    animatedDivTable = document.querySelector('.table-wrapper-first'),
    deg = 0;

// Animating the form border.
function animateDivForm() {
  animatedDivForm.style.background = `background linear-gradient(${deg++}deg, 
  rgba(206,255,0,1) 10% , rgba(143,255,0,1) 30% , rgba(0,255,28,1) 50% ,
  rgba(0,255,150,1) 70% , rgba(0,255,237,1) 90% )`;
  requestAnimationFrame(animateDivForm);
}
requestAnimationFrame(animateDivForm);

// Animating the table border.
function animateDivTable() {
  animatedDivTable.style.background = `background linear-gradient(${deg++}deg, 
  rgba(206,255,0,1) 10% , rgba(143,255,0,1) 30% , rgba(0,255,28,1) 50% ,
  rgba(0,255,150,1) 70% , rgba(0,255,237,1) 90% )`;
  requestAnimationFrame(animateDivTable);
}
requestAnimationFrame(animateDivTable);

// Has no idea how 2 make a single func that can work with the arguments we need.
// F.X. we can call this func and pass the element we want animate.
// Therefore there`ll be no need to repeat the func twice.
// HMU if u have a solution.