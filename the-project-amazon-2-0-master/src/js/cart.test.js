'use strict';
/*

*********COULD NOT GET WORKING PROPERLY, COULDN'T LOAD JQUERY SPOKE TO YOU IN OFFICE ABOUT THIS YOU SAID JUST SUBMIT WHAT WE HAVE**********

*/
//var script = document.createElement('script');
     
//script.src = 'jquery-3.1.1.min.js';
//document.getElementsByTagName('head')[0].appendChild(script); 
window.$ = require('jquery-3.1.1.js');

var itemID = 1;
var uID = 1;
var newAmount = 4;
var uName = "jhabs";
var pass = "password";

test($.post("../php/cartDelete.php", {prodID: itemID, userID: uID}), done => {
  function callback(data) {
    expect(data).toBe('success');
    done();
  }

  fetchData(callback);
});

test($.post("../php/cartAction.php", {prodID: itemID, newAMount: newAmount}), done => {
  function callback(data) {
    expect(data).toBe(newAmount);
    done();
  }

  fetchData(callback);
});

test($.post("../php/processLogin.php", {userName: uName, password: pass}), done => {
  function callback(data) {
    expect(data).toBe('success');
    done();
  }

  fetchData(callback);
});