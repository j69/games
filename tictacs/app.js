var t = new Array(9);

//CELL CLICK EVENT
[].forEach.call(document.querySelectorAll('.cell'), function(el) {
  el.addEventListener('click', function() {
    move(el.id, 'player');
  })
});


function ai() {
  var id = Math.floor(Math.random() * 9);
  t[id] ? ai() : move(id, 'ai');
}

function move(id, role) {
  if(t[id]) return false;
  t[id] = role;
  document.getElementById(id).className = 'cell ' + role;
  //LITTLE AI REACTION DELAY TO LOOK LIKE 'HUMAN'
  setTimeout(function () {
    !checkEnd() ? (role === 'player') ? ai() : null : reset();
  }, 300)
}

function checkEnd() {
  if (t[0]=='ai' && t[1]=='ai' && t[2]=='ai' || t[0]=='player' && t[1]=='player' && t[2]=='player')  return true;
  if (t[3]=='ai' && t[4]=='ai' && t[5]=='ai' || t[3]=='player' && t[4]=='player' && t[5]=='player')  return true;
  if (t[6]=='ai' && t[7]=='ai' && t[8]=='ai' || t[6]=='player' && t[7]=='player' && t[8]=='player')  return true;
  if (t[0]=='ai' && t[3]=='ai' && t[6]=='ai' || t[0]=='player' && t[3]=='player' && t[6]=='player')  return true;
  if (t[1]=='ai' && t[4]=='ai' && t[7]=='ai' || t[1]=='player' && t[4]=='player' && t[7]=='player')  return true;
  if (t[2]=='ai' && t[5]=='ai' && t[8]=='ai' || t[2]=='player' && t[5]=='player' && t[8]=='player')  return true;
  if (t[0]=='ai' && t[4]=='ai' && t[8]=='ai' || t[0]=='player' && t[4]=='player' && t[8]=='player')  return true;
  if (t[2]=='ai' && t[4]=='ai' && t[6]=='ai' || t[2]=='player' && t[4]=='player' && t[6]=='player')  return true;
  if(t[0] && t[1] && t[2] && t[3] && t[4] && t[5] && t[6] && t[7] && t[8]) return true;
}

function reset() {
  alert('GAME OVER!');
  location.reload();
}