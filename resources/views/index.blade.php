<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ASDvisor</title>
    <link rel="stylesheet" href="{{asset('css/main.min.css')}}">

    <!-- bootstrap sass file -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}?v={{time()}}">
  </head>
  <body>
    <nav class="navbar fixed-top navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand me-0" href="#">
          <img src="{{asset('images/asd_1.svg')}}" alt="ASDVISOR" width="30" height="30" />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div
          class="collapse navbar-collapse"
          id="navbarNav"
        >
          <ul class="navbar-nav">
            <li class="nav-item icon mx-2">
              <a
                class="nav-link active"
                href="#home">Home</a>
            </li>
            <li class="nav-item icon mx-2">
              <a
                class="nav-link"
                href="#features">Features</a>
            </li>
        </nav>
    <div class="d-flex align-items-center home" id="home">
        <div class="container"  id="">
            <div class="row">
              <div class="col-xl-6 text-white">
                <h1>Better child management with ASDvisor</h1>
                <h2>A multi-featured application for parents</h2>
                <a href="{{ url('/web/login') }}" class="btn btn-primary btn-lg">Login</a>
                <a href="{{ url('/web/register') }}" class="btn btn-outline-light btn-lg">Register</a>
              </div>
            </div>
          </div>
      
        <!-- <img src="./landing_image.jpg" alt="" class="img-fluid jumbotron"> -->
    </div>
    <div class="container py-5" id="features">
      <h1 class="text-center mb-5">Features</h1>
      <div class="row">
        <div class="col-lg-4 d-flex flex-column justify-content-center align-items-center">
          <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512"
          width="150px"
          height="150px"
          fill="#6750A4">
          <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
          <path
            d="M168 80c-13.3 0-24 10.7-24 24V408c0 8.4-1.4 16.5-4.1 24H440c13.3 0 24-10.7 24-24V104c0-13.3-10.7-24-24-24H168zM72 480c-39.8 0-72-32.2-72-72V112C0 98.7 10.7 88 24 88s24 10.7 24 24V408c0 13.3 10.7 24 24 24s24-10.7 24-24V104c0-39.8 32.2-72 72-72H440c39.8 0 72 32.2 72 72V408c0 39.8-32.2 72-72 72H72zM176 136c0-13.3 10.7-24 24-24h96c13.3 0 24 10.7 24 24v80c0 13.3-10.7 24-24 24H200c-13.3 0-24-10.7-24-24V136zm200-24h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80h32c13.3 0 24 10.7 24 24s-10.7 24-24 24H376c-13.3 0-24-10.7-24-24s10.7-24 24-24zM200 272H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24zm0 80H408c13.3 0 24 10.7 24 24s-10.7 24-24 24H200c-13.3 0-24-10.7-24-24s10.7-24 24-24z"
          />
        </svg>
        <h2 class="text-center mt-2">Daily Care</h2>
        <p class="lead text-center my-2">Read through different Daily Care guides uploaded everyday</p>
        </div>
        <div class="col-lg-4 d-flex flex-column justify-content-center align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
          width="150px"
          height="150px"
          fill="#6750A4"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
          <path d="M320 0a40 40 0 1 1 0 80 40 40 0 1 1 0-80zm44.7 164.3L375.8 253c1.6 13.2-7.7 25.1-20.8 26.8s-25.1-7.7-26.8-20.8l-4.4-35h-7.6l-4.4 35c-1.6 13.2-13.6 22.5-26.8 20.8s-22.5-13.6-20.8-26.8l11.1-88.8L255.5 181c-10.1 8.6-25.3 7.3-33.8-2.8s-7.3-25.3 2.8-33.8l27.9-23.6C271.3 104.8 295.3 96 320 96s48.7 8.8 67.6 24.7l27.9 23.6c10.1 8.6 11.4 23.7 2.8 33.8s-23.7 11.4-33.8 2.8l-19.8-16.7zM40 64c22.1 0 40 17.9 40 40v40 80 40.2c0 17 6.7 33.3 18.7 45.3l51.1 51.1c8.3 8.3 21.3 9.6 31 3.1c12.9-8.6 14.7-26.9 3.7-37.8l-15.2-15.2-32-32c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l32 32 15.2 15.2 0 0 25.3 25.3c21 21 32.8 49.5 32.8 79.2V464c0 26.5-21.5 48-48 48H173.3c-17 0-33.3-6.7-45.3-18.7L28.1 393.4C10.1 375.4 0 351 0 325.5V224 160 104C0 81.9 17.9 64 40 64zm560 0c22.1 0 40 17.9 40 40v56 64V325.5c0 25.5-10.1 49.9-28.1 67.9L512 493.3c-12 12-28.3 18.7-45.3 18.7H400c-26.5 0-48-21.5-48-48V385.1c0-29.7 11.8-58.2 32.8-79.2l25.3-25.3 0 0 15.2-15.2 32-32c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3l-32 32-15.2 15.2c-11 11-9.2 29.2 3.7 37.8c9.7 6.5 22.7 5.2 31-3.1l51.1-51.1c12-12 18.7-28.3 18.7-45.3V224 144 104c0-22.1 17.9-40 40-40z"/>
        </svg>
        <h2 class="text-center mt-2">Care Decision</h2>
        <p class="lead text-center my-2">Get your personalized recommendations based on the parent or childs situation</p>
        
        </div>
        <div class="col-lg-4 d-flex flex-column justify-content-center align-items-center">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
          width="150px"
          height="150px"
          fill="#6750A4"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
            <path d="M480 32c0-12.9-7.8-24.6-19.8-29.6s-25.7-2.2-34.9 6.9L381.7 53c-48 48-113.1 75-181 75H192 160 64c-35.3 0-64 28.7-64 64v96c0 35.3 28.7 64 64 64l0 128c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32V352l8.7 0c67.9 0 133 27 181 75l43.6 43.6c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V300.4c18.6-8.8 32-32.5 32-60.4s-13.4-51.6-32-60.4V32zm-64 76.7V240 371.3C357.2 317.8 280.5 288 200.7 288H192V192h8.7c79.8 0 156.5-29.8 215.3-83.3z"/>
          </svg>
          <h2 class="text-center mt-2">Community</h2>
          <p class="lead text-center my-2">Join on in with the community lead by fellow parents!</p>
          
        </div>
      </div>
    </div>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
    <script>
        document.querySelectorAll('.nav-link').forEach(item => {
          item.addEventListener('click', event => {
            // remove 'active' class from all nav links
            document.querySelectorAll('.nav-link').forEach(navItem => {
              navItem.classList.remove('active');
            });
            // add 'active' class to clicked link
            event.target.classList.add('active');
          });
        });

        // Select all sections and navigation buttons
  const sections = [document.getElementById('home'), document.getElementById('features')];
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Remove active class from all buttons
        document.querySelectorAll('.nav-link').forEach(navItem => {
          navItem.classList.remove('active');
        });

        // Add active class to the corresponding button
        const id = entry.target.getAttribute('id');
        const button = document.querySelector(`.nav-link[href="#${id}"]`);
        if (button) button.classList.add('active');
      }
    });
  }, { threshold: 0.7 });  // Adjust the threshold according to your needs

  // Observe all sections
  sections.forEach(section => observer.observe(section));
      </script>
  </body>
</html>