var form, visor, startBtn, stopBtn, pauseBtn, nextBtn, resumeBtn, documents, n, m, elements;
var started = false, paused = false, stopped = false;

document.addEventListener('DOMContentLoaded', function(evt) {
  form      = document.getElementById('config-form');
  visor     = document.getElementById('visor');
  startBtn  = document.getElementById('start');
  stopBtn   = document.getElementById('stop');
  pauseBtn  = document.getElementById('pause');
  nextBtn   = document.getElementById('next');
  resumeBtn = document.getElementById('resume');

  form.addEventListener('submit', function(evt) {
    evt.preventDefault();
  });

  startBtn.addEventListener('click', function(evt) {
    disable_btns();
    send_request('start');
  });

  stopBtn.addEventListener('click', function(evt) {
    disable_btns();
    stopped = true;
  });

  pauseBtn.addEventListener('click', function(evt) {
    paused = true;

    startBtn.disabled  = true;
    stopBtn.disabled   = false;
    pauseBtn.disabled  = true;
    nextBtn.disabled   = false;
    resumeBtn.disabled = false;
  });

  nextBtn.addEventListener('click', function(evt) {
    send_request('next');
  });

  resumeBtn.addEventListener('click', function(evt) {
    paused = false;

    startBtn.disabled  = true;
    stopBtn.disabled   = false;
    pauseBtn.disabled  = false;
    nextBtn.disabled   = true;
    resumeBtn.disabled = true;

    send_request('next');
  });
});

function send_request(method) {
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4) {
      if (request.status == 200) {
        parse_response(request.responseText);

        if (stopped) send_request('stop');
        else if (started && !paused) send_request('next');

      } else handle_error(request.responseText);
    }
  }

  var data = new FormData(form);
  data.append('method', method);

  request.open('POST', '#');
  request.send(data);
}

function parse_response(response) {
  var data = JSON.parse(response);
  if (data.success) {
    var func = "process_" + data.method;

    if (typeof window[func] === "function") window[func](data);
    else handle_error("method not controlled by the front: " + data.method);

  } else handle_error(data.message);
}

function process_start(data) {
  // Reset the state
  visor.innerHTML = '';
  documents       = 0;
  n               = data.n;
  m               = data.m;
  elements        = [];

  add_info(data.word);

  started = true;
  paused = false;
  stopped = false;

  startBtn.disabled = true;
  stopBtn.disabled = false;
  pauseBtn.disabled = false;
  nextBtn.disabled = true;
  resumeBtn.disabled = true;
}

function process_stop(data) {
  started = false;
  paused = false;
  stopped = false;

  startBtn.disabled  = false;
  stopBtn.disabled   = true;
  pauseBtn.disabled  = true;
  nextBtn.disabled   = true;
  resumeBtn.disabled = true;
}

function process_next(data) {
  add_info(data.word);
}

function add_info(word) {
  if (word == '') return;

  elements.push(word);
  if (elements.length > m) elements.shift();

  documents++;
  show_data();
}

function show_data() {
  visor.innerHTML = '';

  for (var i = 0; i < elements.length; ++i) {
    var div = document.createElement('div');

    div.className = 'row row-' + i;
    div.innerHTML = 'For the ' + n + ' documents analyzed in position ' + (documents + i + 1) + ', the most common word is: ' + elements[i];

    visor.appendChild(div);
  }

}

function handle_error(msg) {
  alert(msg);
  reset_btns();
}

function disable_btns() {
  startBtn.disabled  = true;
  stopBtn.disabled   = true;
  pauseBtn.disabled  = true;
  nextBtn.disabled   = true;
  resumeBtn.disabled = true;
}

function reset_btns() {
  startBtn.disabled  = false;
  stopBtn.disabled   = true;
  pauseBtn.disabled  = true;
  nextBtn.disabled   = true;
  resumeBtn.disabled = true;
}

function reset() {
  started = false;
  paused  = false;
}
