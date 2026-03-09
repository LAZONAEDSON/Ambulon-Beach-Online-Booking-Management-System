<?php
if (session_status() == PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ambulon Beach Resort</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/ambulon_beach_booking/assets/css/site.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="/ambulon_beach_booking/index.php">Ambulon Beach Resort</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/ambulon_beach_booking/index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="/ambulon_beach_booking/rooms.php">Rooms</a></li>
        <li class="nav-item"><a class="nav-link" href="/ambulon_beach_booking/gallery.php">Gallery</a></li>
        <li class="nav-item"><a class="nav-link" href="/ambulon_beach_booking/contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="/ambulon_beach_booking/status.php">Booking Status</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">