const canvas = document.createElement('canvas');
canvas.id = 'mouse-canvas';
document.body.appendChild(canvas);
const ctx = canvas.getContext('2d');
const colours = ['#F73859', '#14FFEC', '#00E0FF', '#FF99FE', '#FAF15D'];

let balls = [];
let pressed = false;
let longPressed = false;
let longPress;
let multiplier = 0;
let width, height;
let origin;
let normal;

// Make the canvas high res
function updateSize() {
  canvas.width = window.innerWidth * 2;
  canvas.height = window.innerHeight * 2;
  canvas.style.width = window.innerWidth + 'px';
  canvas.style.height = window.innerHeight + 'px';
  ctx.scale(2, 2);

  width = canvas.width = window.innerWidth;
  height = canvas.height = window.innerHeight;
  origin = {
    x: width / 2,
    y: height / 2
  };
  normal = {
    x: width / 2,
    y: height / 2
  };
}

updateSize();
window.addEventListener('resize', updateSize, false);

class Ball {
  constructor(x = origin.x, y = origin.y) {
    this.x = x;
    this.y = y;
    this.angle = Math.PI * 2 * Math.random();

    if (longPressed == true) {
      this.multiplier = randBetween(14 + multiplier, 15 + multiplier);
    } else {
      this.multiplier = randBetween(6, 12);
    }

    this.vx = (this.multiplier + Math.random() * 0.5) * Math.cos(this.angle);
    this.vy = (this.multiplier + Math.random() * 0.5) * Math.sin(this.angle);
    this.r = randBetween(5, 10) + 3 * Math.random();
    this.color = colours[Math.floor(Math.random() * colours.length)];
    this.direction = randBetween(-1, 1);
  }

  update() {
    this.x += this.vx - normal.x;
    this.y += this.vy - normal.y;

    normal.x = (-2 / window.innerWidth) * Math.sin(this.angle);
    normal.y = (-2 / window.innerHeight) * Math.cos(this.angle);
    // normal.y = ((-2 / window.innerHeight) * Math.cos(this.angle)) + this.direction;

    this.r -= 0.3;
    this.vx *= 0.9;
    this.vy *= 0.9;
  }
}

function pushBalls(count = 1, x = origin.x, y = origin.y) {
  for (let i = 0; i < count; i++) {
    balls.push(new Ball(x, y));
  }
}

function randBetween(min, max) {
  return Math.floor(Math.random() * max) + min;
}

loop();

function loop() {
  // Alpha means "motion blur", yay!
  // ctx.fillStyle = 'rgba(20, 24, 41, 0.0)';
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  // ctx.fillRect(0, 0, canvas.width, canvas.height);

  for (let i = 0; i < balls.length; i++) {
    let b = balls[i];

    if (b.r < 0) continue;

    ctx.fillStyle = b.color;
    ctx.beginPath();
    ctx.arc(b.x, b.y, b.r, 0, Math.PI * 2, false);
    ctx.fill();

    b.update();
  }

  if (longPressed == true) {
    multiplier += multiplier <= 10 ? 0.2 : 0.0;
  } else if (!longPressed && multiplier >= 0) {
    multiplier -= 0.4;
  }

  removeBall();
  requestAnimationFrame(loop);
}

function removeBall() {
  for (let i = 0; i < balls.length; i++) {
    let b = balls[i];
    if (
      b.x + b.r < 0 ||
      b.x - b.r > width ||
      b.y + b.r < 0 ||
      b.y - b.r > height ||
      b.r < 0
    ) {
      balls.splice(i, 1);
    }
  }
}

window.addEventListener(
  'mousedown',
  function(e) {
    // if (pressed == false) clearInterval(timeOut);

    pressed = true;
    pushBalls(randBetween(10, 20), e.clientX, e.clientY);

    document.body.classList.add('is-pressed');
    longPress = setTimeout(function() {
      document.body.classList.add('is-longpress');
      longPressed = true;
    }, 750);
  },
  false
);

window.addEventListener(
  'mouseup',
  function(e) {
    clearInterval(longPress);
    //multiplier = 0;

    // Superblast
    if (longPressed == true) {
      document.body.classList.remove('is-longpress');
      pushBalls(
        randBetween(50 + Math.ceil(multiplier), 100 + Math.ceil(multiplier)),
        e.clientX,
        e.clientY
      );
      longPressed = false;
    }

    document.body.classList.remove('is-pressed');
  },
  false
);

// Keep it going
// let timeOut = setInterval(function() {
//   pushBalls(
//     randBetween(10, 20),
//     origin.x + randBetween(-50, 50),
//     origin.y + randBetween(-50, 50)
//   );
// }, 200);

// Pointer stuff
const pointer = document.createElement('span');
pointer.classList.add('mouse-pointer');
document.body.appendChild(pointer);

window.addEventListener(
  'mousemove',
  function(e) {
    let x = e.clientX;
    let y = e.clientY;

    pointer.style.top = y + 'px';
    pointer.style.left = x + 'px';
  },
  false
);

document.addEventListener('selectionchange', function() {
  if (pressed) {
    clearInterval(longPress);
    longPressed = false;
    document.body.classList.remove('is-pressed');
    document.body.classList.remove('is-longpress');
  }
});
