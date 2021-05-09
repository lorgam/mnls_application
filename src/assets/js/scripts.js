document.addEventListener('DOMContentLoaded', function(evt) {
  var form = document.getElementById('config-form');

  form.addEventListener('submit', function(evt) {
    evt.preventDefault();
    sendRequest();
  });

  function sendRequest() {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        if (request.status == 200) parseResponse(request.responseText);
        else console.error(request);
      }
    }
    request.open('POST', 'http://localhost/');
    request.send(new FormData(form));
  }

  function parseResponse(response) {
    var data = JSON.parse(response);
  }
});
