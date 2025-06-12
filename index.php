<?php
// index.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Love & Memories - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
background: url('home1.jpg') no-repeat center center fixed;
      background-size: cover;
      position: relative;
      color: #fff;
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.5);
      min-height: 100vh;
      padding-top: 60px;
    }

   .navbar {
  background-color: rgba(0, 0, 0, 0.8);
  position: fixed;
  top: 0;
  width: 100%;
  z-index: 1030;
}

.navbar-brand {
  font-family: 'Brush Script MT', cursive;
  font-weight: bold;
  font-size: 2rem;
  color: #ffc0cb !important;
}

.navbar-nav .nav-link {
  color: #fff !important;
  font-weight: 500;
  transition: color 0.3s ease;
}

.navbar-nav .nav-link:hover {
  color: #87ceeb !important; /* Light Sky Blue on hover */
}

.navbar-nav .nav-link.active {
  color: #87ceeb !important; /* Sky Blue */
  font-weight: bold;
}

    .lead, .display-4 {
      color: #fff;
    }

    .counter-box {
      margin-top: 20px;
    }

    .countdown, .since {
      font-size: 1.2rem;
      font-weight: bold;
      color: #fff;
    }
    .birthday-celebration {
  text-align: center;
  padding: 20px;
  position: relative;
}

.balloons {
  position: relative;
  height: 100px;
  pointer-events: none;
}

.balloon, .heart {
  font-size: 2rem;
  position: absolute;
  animation: floatUp 5s ease-in infinite;
}

.balloon:nth-child(1) { left: 20%; animation-delay: 0s; }
.balloon:nth-child(2) { left: 45%; animation-delay: 1s; }
.balloon:nth-child(3) { left: 65%; animation-delay: 0.5s; }
.balloon:nth-child(4) { left: 85%; animation-delay: 1.5s; }
.heart { left: 50%; animation-delay: 2s; }

@keyframes floatUp {
  0% { bottom: -20px; opacity: 0.6; }
  100% { bottom: 200px; opacity: 1; transform: translateX(20px); }
}

.poem {
  color: #ffd1dc;
  font-style: italic;
  margin-top: 15px;
}

#confetti-canvas {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
}

  </style>
</head>
<body>
  <audio id="bg-music" autoplay loop>
  <source src="song1.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">Love & Memories</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="index.php" class="nav-link active">Home</a></li>
          <li class="nav-item"><a href="timeline.php" class="nav-link">Timeline</a></li>
          <li class="nav-item"><a href="gallery.php" class="nav-link">Gallery</a></li>
          <li class="nav-item"><a href="love_notes.php" class="nav-link">Love Notes</a></li>
          <li class="nav-item"><a href="why.php" class="nav-link">Why I Love You</a></li>
          <li class="nav-item"><a href="surprise.php" class="nav-link">Surprise</a></li>
          <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="overlay d-flex flex-column justify-content-center align-items-center text-center">
    <h1 class="display-4 mb-3">Welcome to Our Love Story</h1>
    <p class="lead">Together, we’ve written a beautiful story—one moment, one memory, one smile at a time.</p>
    <p class="lead">Every heartbeat echoes with the laughter we’ve shared since the day our paths crossed.</p>

    <?php
      date_default_timezone_set('Asia/Karachi');
      $nextAnniv = strtotime('2025-06-13');
      $today = time();
      $diff = $nextAnniv - $today;
      if ($diff > 0) {
          $days = floor($diff / (60*60*24));
          echo "<p class='fs-4 countdown' id='countdown'>Just  <strong>$days</strong> days to go for your big day!</p>";
      } else {
echo "<p class='fs-4 text-warning'>🎂 Happiest Birthday Jaani! 🎉<br> 
محبت کے گلابوں سے سجی ہو زندگی آپ کی،<br>
ہر خوشی ہو قدموں میں، ہر مسکراہٹ ہو آپ کی۔<br>
سالگرہ کا یہ دن لائے خوشیوں کا خزانہ،<br>
آپ جئیں ہزاروں سال، یہی ہے دل کا فسانہ۔ ❤️</p>";
      }
    ?>

    <div class="counter-box">
      <p class="fs-5 since" id="sinceTime">⏳ Time Since We Met: Calculating...</p>
    </div>
  </div>

  <script>
    // Live Anniversary Countdown
    const birthdayDate = new Date("June 13, 2025 00:00:00").getTime();

    const countdownFn = setInterval(() => {
      const now = new Date().getTime();
      const distance = birthdayDate - now;

      if (distance > 0) {
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("countdown").innerHTML =
          `<span class='text-danger'>⏳ Time Left: ${days}d ${hours}h ${minutes}m ${seconds}s</span>`;
      } else {
  clearInterval(countdownFn);
  document.getElementById("countdown").innerHTML = `
    <div class="birthday-celebration">
      <div class="balloons">
        <span class="balloon">🎈</span><span class="balloon">🎈</span>
        <span class="heart">🥳</span><span class="balloon">🎈</span>
      </div>
      <h2 class="text-info">🎉 Happy Birthday, My Jaan! 🎉</h2>
      <p class="fs-5 text-light">May your day be as radiant as your smile, filled with love, laughter, and the sweetest moments. You are my heart, my joy, my everything.</p>
      <p class="poem">
  جن دن سے آیا ہے دل میں سکون، وہ دن ہے جب آپ ملے تھے<br>
  ہر لمحہ آپ کی مسکراہٹ میں جینا چاہا، ہر پل آپ کو دل سے چُنا ہے<br>
  آج جنم دن ہے آپ کا، یہ دن رب کی سب سے خوبصورت عطا ہے<br>
  دعائیں ہیں میری، آپ کی ہر صبح خوشی، ہر رات وفا ہو سجی رہتی رہے 💖<br>
</p>

      <canvas id="confetti-canvas"></canvas>
    </div>
  `;

  startConfetti(); // Start confetti animation
}

    }, 1000);

    // Time Since First Meeting (May 18, 2024 02:00:00)
    const metDate = new Date("May 18, 2024 02:00:00").getTime();

    const sinceFn = setInterval(() => {
      const now = new Date().getTime();
      const elapsed = now - metDate;

      const years = Math.floor(elapsed / (1000 * 60 * 60 * 24 * 365.25));
      const months = Math.floor((elapsed % (1000 * 60 * 60 * 24 * 365.25)) / (1000 * 60 * 60 * 24 * 30.44));
      const days = Math.floor((elapsed % (1000 * 60 * 60 * 24 * 30.44)) / (1000 * 60 * 60 * 24));
      const hours = Math.floor((elapsed % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((elapsed % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((elapsed % (1000 * 60)) / 1000);

      document.getElementById("sinceTime").innerHTML = 
        `❤️ We've been together for ${years}y ${months}m ${days}d ${hours}h ${minutes}m ${seconds}s`;
    }, 1000);

function startConfetti() {
  const canvas = document.getElementById("confetti-canvas");
  const ctx = canvas.getContext("2d");
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  const pieces = [];
  const colors = ["#ff0a54", "#ff477e", "#ffd60a", "#24a0ed", "#80ffdb"];

  for (let i = 0; i < 150; i++) {
    pieces.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height - canvas.height,
      r: Math.random() * 6 + 4,
      d: Math.random() * 10 + 5,
      color: colors[Math.floor(Math.random() * colors.length)],
      tilt: Math.random() * 10 - 10
    });
  }

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    pieces.forEach(p => {
      p.y += Math.cos(0.01 * p.d) + 1 + p.r / 2;
      p.x += Math.sin(0.01 * p.d);
      p.tilt += 0.1;

      ctx.beginPath();
      ctx.lineWidth = p.r / 2;
      ctx.strokeStyle = p.color;
      ctx.moveTo(p.x + p.tilt + p.r / 2, p.y);
      ctx.lineTo(p.x + p.tilt, p.y + p.tilt + p.r / 2);
      ctx.stroke();
    });
    requestAnimationFrame(draw);
  }
  draw();

  window.addEventListener("resize", () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  });
}

 document.addEventListener('DOMContentLoaded', function () {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        // Remove active from all links
        navLinks.forEach(l => l.classList.remove('active'));

        // Add active to clicked link
        this.classList.add('active');
      });
    });
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
