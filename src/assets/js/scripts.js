document.addEventListener('DOMContentLoaded', function(evt) {
  var form = document.getElementById('config-form');
  var documents, n, m;

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
    if (data.success) {
      var visor = document.getElementById('visor');

      switch (data.method) {
        case 'start':
          // Reset the state
          visor.innerHTML = '';
          documents = 0;
          n         = data.n;
          m         = data.m;

          for (var i = 0; i < data.items.length; ++i) {
            var div = document.createElement('div');
            div.className = 'row';
            div.innerHTML = 'For the ' + n + ' documents analyzed in position ' + (++documents) + ', the most common word is: ' + data.items[i];

            visor.appendChild(div);
          }

          break;
        default: alert("method not controlled by the front: " + data.method);
      }

    } else alert(data.message);
  }
});
