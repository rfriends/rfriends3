'use strict';
{
  var button = document.querySelector('button');
  var result = document.querySelector('result');

  button.addEventListener('click', function() {
    var form = document.querySelector('form');
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ajax.php');
    xhr.onload = function() {
      result.textContent = xhr.response;
    };
    xhr.send(new FormData(form));
  });
}