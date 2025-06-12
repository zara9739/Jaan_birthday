<?php
$surpriseMessage = "Surprise! 🎉 Just a little reminder that you are deeply loved, appreciated, and cherished more than words can say. Life is brighter because you're in it. 🌸💖";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Surprise - Love & Memories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
   body {
  background: linear-gradient(to right, #ffc0cb, #87ceeb);
  min-height: 100vh;
  color: #fff;
  font-family: 'Segoe UI', sans-serif;
  display: flex;
  flex-direction: column;
  overflow-x: hidden;
  position: relative;
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


.main-container {
  padding-top: 100px;
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  text-align: center;
  padding-left: 15px;
  padding-right: 15px;
}

.surprise-box {
  background-color: rgba(255, 255, 255, 0.1);
  border: 2px solid #fff;
  border-radius: 20px;
  padding: 40px;
  max-width: 700px;
  width: 100%;
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
  animation: popIn 1s ease-in-out;
}

.surprise-title {
  font-family: 'Brush Script MT', cursive;
  font-size: 2.5rem;
  color: #fff8dc;
  margin-bottom: 20px;
}

.surprise-text {
  font-size: 1.2rem;
  color: #f5f5f5;
  line-height: 1.6;
  margin-bottom: 20px;
}

.surprise-image {
  max-width: 100px;
  height: 80px;
  border-radius: 15px;
  box-shadow: 0 0 10px rgba(255,255,255,0.4);
  margin-top: 20px;
}

@keyframes popIn {
  0% { transform: scale(0.8); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}

/* Hearts */
.heart {
  position: absolute;
  width: 20px;
  height: 20px;
  background: red;
  transform: rotate(45deg);
  animation: floatUp 5s linear forwards;
  opacity: 0.6;
  z-index: 999;
}
.heart::before,
.heart::after {
  content: '';
  position: absolute;
  width: 20px;
  height: 20px;
  background: red;
  border-radius: 50%;
}
.heart::before {
  top: -10px;
  left: 0;
}
.heart::after {
  top: 0;
  left: -10px;
}

@keyframes floatUp {
  0% {
    transform: translateY(0) rotate(45deg);
    opacity: 0.8;
  }
  100% {
    transform: translateY(-120vh) rotate(45deg);
    opacity: 0;
  }
}

@media (max-width: 576px) {
  .surprise-title {
    font-size: 2rem;
  }
  .surprise-text {
    font-size: 1rem;
  }
  .surprise-box {
    padding: 25px;
  }
}

  </style>
</head>
<body>

<!-- Romantic Music -->

<audio id="bg-music" autoplay loop>
  <source src="song5.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<!-- Hearts -->
<div id="hearts-container"></div>

<!-- Confetti Canvas -->
<canvas id="confetti-canvas" style="position:fixed;top:0;left:0;pointer-events:none;z-index:999;"></canvas>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Love & Memories</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="timeline.php" class="nav-link">Timeline</a></li>
        <li class="nav-item"><a href="gallery.php" class="nav-link">Gallery</a></li>
        <li class="nav-item"><a href="love_notes.php" class="nav-link">Love Notes</a></li>
        <li class="nav-item"><a href="why.php" class="nav-link">Why I Love You</a></li>
        <li class="nav-item"><a href="surprise.php" class="nav-link active">Surprise</a></li>
        <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Message Section -->
<div class="main-container">
  <div class="surprise-box">
    <h2 class="surprise-title">🎁 A Sweet Surprise 🎁</h2>
    <p class="surprise-text"><?= htmlspecialchars($surpriseMessage) ?></p>
    <img src="surprise.gif" alt="Surprise Image" class="surprise-image">
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
  // Launch confetti on load
  confetti({
    particleCount: 150,
    spread: 100,
    origin: { y: 0.6 }
  });

  // Floating hearts
  function createHeart() {
    const heart = document.createElement('div');
    heart.className = 'heart';
    heart.style.left = Math.random() * 100 + 'vw';
    heart.style.top = (Math.random() * 40 + 50) + 'vh'; // start from bottom half
    heart.style.animationDuration = (Math.random() * 3 + 2) + 's';
    document.getElementById('hearts-container').appendChild(heart);
    setTimeout(() => heart.remove(), 5000);
  }

  setInterval(createHeart, 300);
</script>

</body>
</html>
