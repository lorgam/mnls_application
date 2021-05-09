document.addEventListener("DOMContentLoaded", function(evt) {
  let form = document.getElementById('config-form');

  form.addEventListener('submit', function(evt) {
    evt.preventDefault();
    console.log('submit');
  });
});
