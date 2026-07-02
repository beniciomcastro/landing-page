/*
  Canvas background animation.
  Creates a subtle continuous code-rain effect behind the interface.
*/
const canvas = document.getElementById("bgCanvas");
if (canvas) {
  const ctx = canvas.getContext("2d");

let width = 0;
let height = 0;
let columns = [];
let mouseX = 0;
let mouseY = 0;
let mouseActive = false;

const snippets = [
  "const app = true;",
  "function render()",
  "return project;",
  "async await",
  "class Project",
  "public static",
  "password_verify()",
  "csrf_token",
  "SELECT * FROM projects",
  "INSERT INTO users",
  "CREATE TABLE",
  "docker compose up",
  "php artisan",
  "mysql",
  "javascript",
  "<main>",
  "</section>",
  "git push",
  "linux",
  "render",
  "aiven",
  "{}",
  "[]",
  "()",
  "=>",
  "===",
];

const colors = [
  "rgba(81, 202, 255, 0.32)",
  "rgba(255, 137, 43, 0.28)",
  "rgba(116, 219, 255, 0.25)",
  "rgba(255, 255, 255, 0.18)",
];

function resize() {
  const ratio = window.devicePixelRatio || 1;

  width = window.innerWidth;
  height = window.innerHeight;

  canvas.width = width * ratio;
  canvas.height = height * ratio;

  canvas.style.width = `${width}px`;
  canvas.style.height = `${height}px`;

  ctx.setTransform(ratio, 0, 0, ratio, 0, 0);

  createColumns();
}

function createColumns() {
  const spacing = width < 620 ? 110 : 150;
  const amount = Math.ceil(width / spacing) + 6;

  columns = Array.from({ length: amount }, (_, index) => {
    const gap = 42 + Math.random() * 28;
    const length = Math.ceil(height / gap) + 8;

    return {
      x: index * spacing + Math.random() * 50 - 50,
      speed: 0.28 + Math.random() * 0.42,
      size: width < 620 ? 13 : 15,
      gap,
      length,
      color: colors[index % colors.length],
      drift: Math.random() * Math.PI * 2,
      items: Array.from({ length }, (_, itemIndex) => ({
        text: snippets[Math.floor(Math.random() * snippets.length)],
        y: itemIndex * gap - Math.random() * height,
        alpha: 0.35 + Math.random() * 0.45,
      })),
    };
  });
}

function drawBackground() {
  const gradient = ctx.createLinearGradient(0, 0, width, height);

  gradient.addColorStop(0, "#10151d");
  gradient.addColorStop(0.5, "#151821");
  gradient.addColorStop(1, "#1b1b23");

  ctx.fillStyle = gradient;
  ctx.fillRect(0, 0, width, height);

  const blueGlow = ctx.createRadialGradient(
    width * 0.18,
    height * 0.16,
    0,
    width * 0.18,
    height * 0.16,
    width * 0.52,
  );

  blueGlow.addColorStop(0, "rgba(81, 202, 255, 0.08)");
  blueGlow.addColorStop(1, "transparent");

  ctx.fillStyle = blueGlow;
  ctx.fillRect(0, 0, width, height);

  const orangeGlow = ctx.createRadialGradient(
    width * 0.82,
    height * 0.25,
    0,
    width * 0.82,
    height * 0.25,
    width * 0.46,
  );

  orangeGlow.addColorStop(0, "rgba(255, 137, 43, 0.065)");
  orangeGlow.addColorStop(1, "transparent");

  ctx.fillStyle = orangeGlow;
  ctx.fillRect(0, 0, width, height);
}

function drawColumn(column, time) {
  const drift = Math.sin(time * 0.00045 + column.drift) * 10;

  ctx.font = `${column.size}px Consolas, Monaco, "Courier New", monospace`;
  ctx.textBaseline = "top";
  ctx.shadowBlur = 6;

  column.items.forEach((item, index) => {
    if (item.y < -60 || item.y > height + 60) return;

    const pulse = 0.75 + Math.sin(time * 0.001 + index + column.drift) * 0.25;

    ctx.globalAlpha = item.alpha * pulse * 0.9;
    ctx.fillStyle = column.color;
    ctx.shadowColor = column.color;

    ctx.fillText(item.text, column.x + drift, item.y);
  });

  ctx.shadowBlur = 0;
  ctx.globalAlpha = 1;
}

function animate(time = 0) {
  drawBackground();

  columns.forEach((column) => {
    column.items.forEach((item) => {
      item.y += column.speed;

      if (item.y > height + 60) {
        item.y = -column.gap - Math.random() * 120;
        item.text = snippets[Math.floor(Math.random() * snippets.length)];
        item.alpha = 0.35 + Math.random() * 0.65;
      }
    });

    drawColumn(column, time);
  });

  requestAnimationFrame(animate);
}

window.addEventListener("resize", resize);

window.addEventListener("mousemove", (event) => {
  mouseX = event.clientX;
  mouseY = event.clientY;
  mouseActive = true;
});

window.addEventListener("mouseleave", () => {
  mouseActive = false;
});

resize();
animate();
}
