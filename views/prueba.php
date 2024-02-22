<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    .rating {
      font-size: 30px;
      unicode-bidi: bidi-override;
      direction: rtl;
      display: inline-block;
    }

    .star {
      display: inline-block;
      position: relative;
      width: 1.1em;
      height: 1em;
    }

    .star::before {
      content: '\2605'; /* Código Unicode de la estrella rellena */
      position: absolute;
    }

    .star.half::before {
      content: '\2605'; /* Código Unicode de la estrella rellena */
      clip: rect(0, 0.4em, 1em, 0);
      position: absolute;
    }
  </style>
</head>
<body>
  <div class="rating">
    <div class="star half"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
  </div>
</body>
</html>
