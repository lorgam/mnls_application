var form, documents, n, m;

document.addEventListener('DOMContentLoaded', function(evt) {
  form = document.getElementById('config-form');

  form.addEventListener('submit', function(evt) {
    evt.preventDefault();
    sendRequest('start');
  });
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
    var func = "process_" + data.method;

    if (typeof window[func] === "function") window[func](data);
    else alert("method not controlled by the front: " + data.method);

  } else alert(data.message);
}

function process_start(data) {
  var visor = document.getElementById('visor');
  // Reset the state
  visor.innerHTML = '';
  documents       = 0;
  n               = data.n;
  m               = data.m;

  var div = document.createElement('div');
  div.className = 'row';
  div.innerHTML = 'For the ' + n + ' documents analyzed in position ' + (++documents) + ', the most common word is: ' + data.word;

  visor.appendChild(div);
}

function process_stop(data) {
  console.log('stop', data);
}

function process_next(data) {
  console.log('next', data);
}
