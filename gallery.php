<?php
// Delete logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
  $fileToDelete = 'images/' . basename($_POST['delete']);
  if (file_exists($fileToDelete)) {
    unlink($fileToDelete); // Delete the file
  }
  header("Location: gallery.php");
  exit;
}

// Upload logic
$uploadError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
  $targetDir = "images/";
  $filename = basename($_FILES["image"]["name"]);
  $targetFile = $targetDir . $filename;

  $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
  $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  if (in_array($imageFileType, $allowedTypes)) {
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
      header("Location: gallery.php");
      exit;
    } else {
      $uploadError = "Failed to upload image.";
    }
  } else {
    $uploadError = "Only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
  }
}

// Get images from folder
$images = array_values(array_filter(scandir("images/"), function ($file) {
  return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
}));
$total = count($images);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Love & Memories - Gallery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(to bottom right, #f8bbd0, #b3e5fc);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
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


    .gallery-container {
      padding: 100px 15px 40px;
    }

    .gallery-title {
      text-align: center;
      color: #d63384;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .carousel-item img {
      display: block;
      max-height: 500px;
      max-width: 100%;
      height: auto;
      object-fit: contain;
      border-radius: 10px;
      margin-left: auto;
      margin-right: auto;
    }

    .image-counter {
      text-align: center;
      margin-top: 10px;
      font-weight: bold;
      color: #6c3483;
    }

    .upload-form .form-control {
      margin-right: 10px;
    }

    @media (max-width: 768px) {
      .carousel-item img {
        max-height: 300px;
      }

      .upload-form {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
<audio id="bg-music" autoplay loop>
  <source src="song2.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="index.php">Love & Memories</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
        <li class="nav-item"><a href="timeline.php" class="nav-link">Timeline</a></li>
        <li class="nav-item"><a href="gallery.php" class="nav-link active">Gallery</a></li>
        <li class="nav-item"><a href="love_notes.php" class="nav-link">Love Notes</a></li>
        <li class="nav-item"><a href="why.php" class="nav-link">Why I Love You</a></li>
        <li class="nav-item"><a href="surprise.php" class="nav-link">Surprise</a></li>
        <li class="nav-item"><a href="birthday_game.php" class="nav-link">Birthday Game</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container gallery-container position-relative">

  <h2 class="gallery-title">Our Beautiful Moments Together 💖</h2>

  <!-- Upload form -->
  <div class="row justify-content-center mb-4">
    <div class="col-md-6 col-sm-12">
      <form class="upload-form d-flex" action="gallery.php" method="POST" enctype="multipart/form-data">
        <div class="input-group">
          <input type="file" name="image" accept="image/*" required class="form-control" />
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
        <?php if ($uploadError): ?>
          <div class="text-danger mt-1"><?= $uploadError ?></div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Carousel -->
  <div id="galleryCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php foreach ($images as $index => $img): ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <div class="position-relative">
            <img src="images/<?= htmlspecialchars($img) ?>" alt="Memory <?= $index + 1 ?>" />
            
            <!-- Delete Button -->
            <form class="text-center mt-2" method="POST" onsubmit="return confirm('Are you sure you want to delete this photo?')" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%);">
              <input type="hidden" name="delete" value="<?= htmlspecialchars($img) ?>">
              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#galleryCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#galleryCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>

  <!-- Image counter -->
  <div class="image-counter">
    <span id="counterText">1 / <?= $total ?></span>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const total = <?= $total ?>;
  const counter = document.getElementById("counterText");
  const carousel = document.getElementById("galleryCarousel");

  carousel.addEventListener('slid.bs.carousel', function (e) {
    const currentIndex = e.to + 1;
    counter.innerText = `${currentIndex} / ${total}`;
  });
</script>
</body>
</html>
