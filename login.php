<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="p-3 mb-2 bg-primary-subtle text-primary-emphasis">
  <div class="container">
    <div class="text-center">
      <form style="max-width:480px; margin:auto;">
        <img class="mt-5 mb-4" src="images/logo_schnell.png" height="72" alt="logo_kostenklar">
        <h1 class="h3-3 font-weight-normal"> Please sign in</h1>

        <label for="emailAddres" class="sr-only"> </label>
        <input type="email" id="emailAddress" class="form-control" placeholder="Email Address" requiered autofocus>

        <label for="password" class="sr-only"></label>
        <input type="password" id="password" placeholder="Password" class="form-control">

        <div class="checkbox">
          <label> <input type="checkbox" value="remember-me"> Remember me </label>
        </div>

        <div class="mt-3">
          <button class="btn btn-lg btn-primary btn-block"> Sign in</button>
        </div>

      </form>
    </div>

  </div>

</body>

</html>