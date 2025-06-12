<?php
$points = [
  "You are my sunshine in every rainy day.",
  "Your smile makes my heart skip a beat.",
  "I love you for your kindness and strength.",
  "Every moment with you is a treasure.",
  "You are my big supporter__ Please stay always meri jaan.",
  "You complete me in ways I never knew possible.",
  "You are different from everyone else — you know how to respect, truly and deeply.",
  "You're a blessing to your loving parents and siblings — they are so lucky to have you.",
  "Your presence makes every ordinary moment feel magical.",
  "You listen not just with your ears, but with your heart.",
  "You're not perfect, but you always try — and that means the world to me.",
  "With you, I feel safe, valued, and endlessly loved.",
  "Even your silence speaks comfort to my soul.",
  "You inspire me to become a better version of myself.",
  "You are not just my partner, you are my best friend, my safe place, and my greatest gift."
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Why I Love You - Love & Memories</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('why.jpg');
      background-repeat: no-repeat;
      background-size: auto;
      background-position: center top;
      background-attachment: fixed;
      min-height: 100vh;
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      overflow-x: hidden;
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
    }
    .love-box {
      background-color: rgba(255, 255, 255, 0.1);
      border: 1px solid #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
    }
    .love-title {
      font-family: 'Brush Script MT', cursive;
      font-size: 2.5rem;
      margin-bottom: 20px;
      text-align: center;
      color: rgb(60, 37, 230);
    }
    .list-group-item {
      background-color: rgba(255, 255, 255, 0.15);
      border: none;
      color: rgb(5, 5, 5);
      font-size: 1.1rem;
      margin-bottom: 10px;
      transition: all 0.3s ease;
    }
    .list-group-item:hover {
      background-color: rgba(255, 255, 255, 0.25);
      transform: scale(1.02);
    }

    /* Floating Emoji Styles */
    .emoji {
      position: fixed;
      font-size: 2rem;
      animation: float 8s linear infinite;
      pointer-events: none;
      z-index: 999;
    }
    @keyframes float {
      0% {
        transform: translateY(100vh) rotate(0deg);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      100% {
        transform: translateY(-10vh) rotate(360deg);
        opacity: 0;
      }
    }
  </style>
</head>
<body>
<audio id="bg-music" autoplay loop>
  <source src="song4.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
<!-- Floating Emojis -->
<?php for ($i = 0; $i < 30; $i++): ?>
  <div class="emoji" style="left: <?= rand(0, 100) ?>vw; animation-delay: <?= rand(0, 10) ?>s;">
    <?= $i % 2 == 0 ? "😍" : "😘" ?>
  </div>
<?php endfor; ?>

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
        <li class="nav-item"><a href="why.php" class="nav-link active">Why I Love You</a></li>
        <li class="nav-item"><a href="surprise.php" class="nav-link">Surprise</a></li>
        <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container main-container">
  <div class="love-box mx-auto" style="max-width: 700px;">
    <h2 class="love-title">💖 Why I Love You 💖</h2>
    <ul class="list-group">
      <?php foreach ($points as $point): ?>
        <li class="list-group-item"><?= htmlspecialchars($point) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
