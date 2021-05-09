document.addEventListener('DOMContentLoaded', function(evt) {
  var form = document.getElementById('config-form');
  var documents, n, m;

  form.addEventListener('submit', function(evt) {
    evt.preventDefault();
    sendRequest('start');
  });

  function sendRequest(method) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
      if (request.readyState == 4) {
        if (request.status == 200) parseResponse(request.responseText);
        else console.error(request);
      }
    }

    var data = new FormData(form);
    data.append('method', method);

    request.open('POST', 'https://localhost/');
    request.send(data);
  }

  function parseResponse(response) {
    var data = JSON.parse(response);
    if (data.success) {
      var visor = document.getElementById('visor');

      switch (data.method) {
        case 'start':
          // Reset the state
          visor.innerHTML = '';
          documents = 0;
          n         = data.n;
          m         = data.m;

          var div = document.createElement('div');
          div.className = 'row';
          div.innerHTML = 'For the ' + n + ' documents analyzed in position ' + (++documents) + ', the most common word is: ' + data.word;

          visor.appendChild(div);

          break;
        default: alert("method not controlled by the front: " + data.method);
      }

    } else alert(data.message);
  }
});
