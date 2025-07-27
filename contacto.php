<?php

session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contacto – Pet Homeless</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link href="css/style.css" rel="stylesheet" />

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    integrity="sha512-p8f+V3UOiF0eFfVIYgU8bYJI7cKXCZ+V+3ZYoY6LZVYQbjJjBl9Ih/u6hbkkaR2l6wG6DFp0KU9IYF4v70z1Kg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  />
</head>
<body>
  <?php include 'layout/nav.php'; ?>

  <header class="bg-secondary text-white text-center py-5 mb-4 banner">
    <div class="container">
      <h1 class="display-4">Contáctanos</h1>
      <p class="lead">Estamos aquí para ayudarte</p>
    </div>
  </header>

  <main class="container mb-5">
    <div class="row gy-4">

 
      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">Chat por WhatsApp</h5>
            <p class="card-text flex-grow-1">
              ¿Tienes dudas o necesitas ayuda inmediata?
              Escríbenos directamente a nuestro WhatsApp.
            </p>
            <a
              href="https://api.whatsapp.com/send?phone=+50688888888&text=¡Hola!%20Quisiera%20más%20información%20sobre%20Pet%20Homeless."
              target="_blank"
              class="btn btn-success mt-auto"
            >
              <i class="fa-brands fa-whatsapp"></i> Chatear en WhatsApp
            </a>
          </div>
        </div>
      </div>


      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Envíanos un mensaje</h5>

            <form
              id="my-form"
              class="needs-validation"
              action="https://formspree.io/f/xldlbkvq"
              method="POST"
              novalidate
            >
              <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input
                  type="text"
                  class="form-control"
                  id="name"
                  name="name"
                  placeholder="Escribe tu nombre"
                  required
                />
                <div class="invalid-feedback">
                  Por favor ingresa tu nombre.
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                  type="email"
                  class="form-control"
                  id="email"
                  name="email"
                  placeholder="Escribe tu correo"
                  required
                />
                <div class="invalid-feedback">
                  Por favor ingresa un correo válido.
                </div>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Mensaje</label>
                <textarea
                  class="form-control"
                  id="message"
                  name="message"
                  rows="4"
                  placeholder="Escribe tu mensaje aquí..."
                  required
                ></textarea>
                <div class="invalid-feedback">
                  El mensaje no puede estar vacío.
                </div>
              </div>

              <button
                id="my-form-button"
                class="btn btn-primary w-100"
                type="submit"
              >
                Enviar Mensaje
              </button>
              <p id="my-form-status" class="mt-3 text-center"></p>
            </form>

          </div>
        </div>
      </div>
    </div>
  </main>

  <button id="backToTop" title="Volver arriba">↑</button>
  <button id="themeToggle" title="Cambiar tema">🌙</button>
  <?php include 'layout/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/actuar.js"></script>
</body>
</html>
