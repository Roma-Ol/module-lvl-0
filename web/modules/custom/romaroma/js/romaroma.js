"use strict";

let animatedDivForm = document.querySelector('.form-wrapper-first'),
    animatedDivTable = document.querySelector('.table-wrapper-first'),
    deg = 0;

function animateDivForm() {
  animatedDivForm.style.background = `background linear-gradient(${deg++}deg, 
  rgba(206,255,0,1) 10% , rgba(143,255,0,1) 30% , rgba(0,255,28,1) 50% ,
  rgba(0,255,150,1) 70% , rgba(0,255,237,1) 90% )`;
  requestAnimationFrame(animateDivForm);
}
requestAnimationFrame(animateDivForm);

function animateDivTable() {
  animatedDivTable.style.background = `background linear-gradient(${deg++}deg, 
  rgba(206,255,0,1) 10% , rgba(143,255,0,1) 30% , rgba(0,255,28,1) 50% ,
  rgba(0,255,150,1) 70% , rgba(0,255,237,1) 90% )`;
  requestAnimationFrame(animateDivTable);
}
requestAnimationFrame(animateDivTable);