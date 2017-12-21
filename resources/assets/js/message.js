let timer = 3;

window.setTimeout(() => {
  window.location.href = '/';
}, 3500);

window.setInterval(() => {
  timer = timer - 1;
  document.getElementById('time').innerText = timer;
}, 1000);
